<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\WorkDistribution; // Uncomment if model exists

class WorkDistributionController extends Controller
{
    public function index()
    {
        $tasks = \App\Models\Task::with(['assignedTo'])->latest()->get();
        return view('admin.work_distribution.index', compact('tasks'));
    }

    public function create()
    {
        $users = \App\Models\User::where('role', '!=', 'administrator')->get();
        // Gather all unique skills from users
        $allSkills = $users->pluck('skills')->flatten()->unique()->filter()->values();
        return view('admin.work_distribution.create', compact('users', 'allSkills'));
    }

    /**
     * Store a new work distribution task with automatic assignment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        // Find the category and best assignee
        $category = \App\Models\TaskCategory::where('name', $validated['category'])->first();
        $assignee = $category ? $category->getBestAssignee() : null;
        $assignmentMethod = 'auto';
        $assignmentReason = $assignee ? 'Assigned to ' . $assignee->name . ' (least busy ' . ucfirst($assignee->role) . ')' : 'No eligible user found';

        $task = \App\Models\Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_by' => auth()->id(),
            'assigned_to' => $assignee?->id,
            'priority' => $validated['priority'],
            'category' => $validated['category'],
            'due_date' => $validated['due_date'],
            'status' => 'pending',
            'assignment_method' => $assignmentMethod,
            'assignment_reason' => $assignmentReason,
            'location' => $validated['location'],
            'contact' => $validated['contact'],
            'is_read' => false,
        ]);
        // Notify the assignee
        if ($assignee) {
            $assignee->notify(new \App\Notifications\TaskStatusNotification('You have been assigned a new task: "' . $task->title . '"', $task->id));
        }

        return redirect()->route('admin.work-distribution.index')->with('success', 'Task created and auto-assigned professionally.');
    }

    /**
     * Mark a task as acknowledged (read) by the assigned user
     */
    public function acknowledge(\App\Models\Task $task)
    {
        if (auth()->id() === $task->assigned_to) {
            $task->markAsRead();
            return back()->with('success', 'Task acknowledged successfully.');
        }
        return back()->with('error', 'You are not authorized to acknowledge this task.');
    }

    /**
     * Reassign a task to a new user and log the change.
     */
    public function reassign(Request $request, \App\Models\Task $task)
    {
        $validated = $request->validate([
            'new_assigned_to' => 'required|exists:users,id',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldAssignee = $task->assigned_to;
        $newAssignee = $validated['new_assigned_to'];
        $reason = $validated['reason'] ?? 'Reassignment by admin';

        // Update task assignment
        $task->update([
            'assigned_to' => $newAssignee,
            'assignment_method' => 'manual',
            'assignment_reason' => $reason,
        ]);

        // Log audit
        \App\Models\TaskAssignmentAudit::create([
            'task_id' => $task->id,
            'old_assigned_to' => $oldAssignee,
            'new_assigned_to' => $newAssignee,
            'changed_by' => auth()->id(),
            'reason' => $reason,
        ]);

        // Notify new assignee
        $user = \App\Models\User::find($newAssignee);
        if ($user) {
            $user->notify(new \App\Notifications\TaskStatusNotification('You have been reassigned a task: "' . $task->title . '"', $task->id));
        }

        return redirect()->route('admin.work-distribution.index')->with('success', 'Task reassigned successfully.');
    }

    /**
     * Delete a task (soft delete)
     */
    public function destroy(\App\Models\Task $task)
    {
        $task->delete();
        return redirect()->route('admin.work-distribution.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Show the assignment audit history for a task.
     */
    public function showHistory(\App\Models\Task $task)
    {
        $audits = $task->assignmentAudits()->with(['oldAssignee', 'newAssignee', 'changer'])->latest()->get();
        $comments = $task->comments()->with('user')->latest()->get();
        return view('admin.work_distribution.history', compact('task', 'audits', 'comments'));
    }

    /**
     * Add a comment to a task and notify the assignee.
     */
    public function addComment(Request $request, \App\Models\Task $task)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'is_internal' => 'nullable|boolean',
        ]);

        $comment = \App\Models\TaskComment::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
            'is_internal' => $validated['is_internal'] ?? false,
        ]);

        // Notify assignee
        if ($task->assignedTo && $task->assigned_to !== auth()->id()) {
            $task->assignedTo->notify(new \App\Notifications\TaskStatusNotification('A new comment was added to your task: "' . $task->title . '"', $task->id));
        }

        return redirect()->route('admin.work-distribution.history', $task->id)->with('success', 'Comment added successfully.');
    }

    /**
     * Update the status of a task, log the change, and notify the assignee.
     */
    public function updateStatus(Request $request, \App\Models\Task $task)
    {
        $validated = $request->validate([
            'new_status' => 'required|in:pending,in_progress,completed,cancelled',
            'reason' => 'nullable|string|max:255',
        ]);

        // Only admin or assigned user can change status
        if (!(auth()->user()->isAdmin() || auth()->id() === $task->assigned_to)) {
            return back()->with('error', 'You are not authorized to change the status of this task.');
        }

        $oldStatus = $task->status;
        $newStatus = $validated['new_status'];
        $reason = $validated['reason'] ?? null;

        // Update status
        $task->update(['status' => $newStatus]);

        // Log audit
        \App\Models\TaskStatusAudit::create([
            'task_id' => $task->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => auth()->id(),
            'reason' => $reason,
        ]);

        // Notify assignee
        if ($task->assignedTo) {
            $task->assignedTo->notify(new \App\Notifications\TaskStatusNotification('Status of your task "' . $task->title . '" changed to ' . ucfirst($newStatus) . '.', $task->id));
        }

        return redirect()->route('admin.work-distribution.index')->with('success', 'Task status updated successfully.');
    }

    /**
     * Professional Work Distribution Report
     */
    public function report(Request $request)
    {
        $tasks = \App\Models\Task::with(['assignedTo'])->get();
        $users = \App\Models\User::where('role', '!=', 'administrator')->get();
        $categories = \App\Models\TaskCategory::all();

        // Summary stats
        $stats = [
            'total' => $tasks->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
            'pending' => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'overdue' => $tasks->filter(fn($t) => $t->is_overdue)->count(),
        ];

        // Group by user/category
        $byUser = $tasks->groupBy('assigned_to');
        $byCategory = $tasks->groupBy('category');

        return view('admin.work_distribution.report', compact('tasks', 'users', 'categories', 'stats', 'byUser', 'byCategory'));
    }
} 