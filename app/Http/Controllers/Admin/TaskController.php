<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskComment;
use App\Models\TaskTimeLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks with filtering and search
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignedBy', 'assignedTo']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('assignee')) {
            $query->where('assigned_to', $request->assignee);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply date filters
        if ($request->filled('due_date')) {
            switch ($request->due_date) {
                case 'today':
                    $query->dueToday();
                    break;
                case 'this_week':
                    $query->dueThisWeek();
                    break;
                case 'overdue':
                    $query->overdue();
                    break;
            }
        }

        $tasks = $query->latest()->paginate(15);

        // Get filter options
        $users = User::where('role', '!=', 'administrator')->get();
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled', 'on_hold'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $categories = ['production', 'inventory', 'quality_control', 'delivery', 'maintenance', 'admin', 'customer_service', 'other'];

        // Get statistics
        $stats = [
            'total' => Task::count(),
            'pending' => Task::pending()->count(),
            'in_progress' => Task::inProgress()->count(),
            'completed' => Task::completed()->count(),
            'overdue' => Task::overdue()->count(),
        ];

        return view('admin.tasks.index', compact('tasks', 'users', 'statuses', 'priorities', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new task
     */
    public function create()
    {
        $users = User::where('role', '!=', 'administrator')->get();
        $categories = ['production', 'inventory', 'quality_control', 'delivery', 'maintenance', 'admin', 'customer_service', 'other'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        return view('admin.tasks.create', compact('users', 'categories', 'priorities'));
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'nullable', // allow null or 'auto'
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|in:production,inventory,quality_control,delivery,maintenance,admin,customer_service,other',
            'due_date' => 'nullable|date|after:now',
            'estimated_hours' => 'nullable|integer|min:1',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $assignedTo = $request->assigned_to;
        if (!$assignedTo || $assignedTo === 'auto') {
            $assignedTo = $this->findBestUserForTask($request->category);
            if (!$assignedTo) {
                return back()->with('error', 'No available user with the required skill for this task category.');
            }
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_by' => Auth::id(),
            'assigned_to' => $assignedTo,
            'priority' => $request->priority,
            'category' => $request->category,
            'due_date' => $request->due_date,
            'estimated_hours' => $request->estimated_hours,
            'location' => $request->location,
            'notes' => $request->notes,
        ]);

        // Create initial comment if provided
        if ($request->filled('initial_comment')) {
            TaskComment::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'comment' => $request->initial_comment,
                'is_internal' => false,
            ]);
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task created successfully and assigned to ' . $task->assignedTo->name);
    }

    /**
     * Find the best user for a task based on skill, availability, and workload
     */
    protected function findBestUserForTask($requiredSkill)
    {
        $users = User::where('role', '!=', 'administrator')
            ->where('is_available', true)
            ->get();

        // Filter users who have the required skill
        $filtered = $users->filter(function($user) use ($requiredSkill) {
            return is_array($user->skills) && in_array($requiredSkill, $user->skills);
        });

        if ($filtered->isEmpty()) {
            return null;
        }

        // Return the user with the least number of active tasks
        return $filtered->sortBy(function($user) {
            return $user->assignedTasks()->whereNotIn('status', ['completed', 'cancelled'])->count();
        })->first()->id;
    }

    /**
     * Display the specified task
     */
    public function show(Task $task)
    {
        $task->load(['assignedBy', 'assignedTo', 'comments.user', 'timeLogs.user']);
        
        // Get related tasks
        $relatedTasks = Task::where('assigned_to', $task->assigned_to)
            ->where('id', '!=', $task->id)
            ->where('status', '!=', 'completed')
            ->take(5)
            ->get();

        return view('admin.tasks.show', compact('task', 'relatedTasks'));
    }

    /**
     * Show the form for editing the specified task
     */
    public function edit(Task $task)
    {
        $users = User::where('role', '!=', 'administrator')->get();
        $categories = ['production', 'inventory', 'quality_control', 'delivery', 'maintenance', 'admin', 'customer_service', 'other'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled', 'on_hold'];

        return view('admin.tasks.edit', compact('task', 'users', 'categories', 'priorities', 'statuses'));
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|in:production,inventory,quality_control,delivery,maintenance,admin,customer_service,other',
            'status' => 'required|in:pending,in_progress,completed,cancelled,on_hold',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|integer|min:1',
            'actual_hours' => 'nullable|integer|min:1',
            'progress_percentage' => 'nullable|numeric|min:0|max:100',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $task->update($request->all());

        // If status changed to completed, set completed_at
        if ($request->status === 'completed' && $task->status !== 'completed') {
            $task->update(['completed_at' => now()]);
        }

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified task
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully');
    }

    /**
     * Bulk assign tasks to users
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:tasks,id',
            'assigned_to' => 'required|exists:users,id',
        ]);

        Task::whereIn('id', $request->task_ids)->update([
            'assigned_to' => $request->assigned_to
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success', count($request->task_ids) . ' tasks assigned successfully');
    }

    /**
     * Bulk update task status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'exists:tasks,id',
            'status' => 'required|in:pending,in_progress,completed,cancelled,on_hold',
        ]);

        $updateData = ['status' => $request->status];
        
        if ($request->status === 'completed') {
            $updateData['completed_at'] = now();
            $updateData['progress_percentage'] = 100;
        }

        Task::whereIn('id', $request->task_ids)->update($updateData);

        return redirect()->route('admin.tasks.index')
            ->with('success', count($request->task_ids) . ' tasks status updated successfully');
    }

    /**
     * Add comment to task
     */
    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'is_internal' => $request->is_internal ?? false,
        ]);

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Comment added successfully');
    }

    /**
     * Start time tracking for a task
     */
    public function startTimer(Request $request, Task $task)
    {
        // Check if user already has a running timer
        $runningTimer = TaskTimeLog::where('user_id', Auth::id())
            ->whereNull('end_time')
            ->first();

        if ($runningTimer) {
            return back()->with('error', 'You already have a running timer. Please stop it first.');
        }

        TaskTimeLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'start_time' => now(),
            'activity_type' => $request->activity_type ?? 'work',
            'description' => $request->description,
        ]);

        return back()->with('success', 'Timer started successfully');
    }

    /**
     * Stop time tracking for a task
     */
    public function stopTimer(Request $request, Task $task)
    {
        $timeLog = TaskTimeLog::where('task_id', $task->id)
            ->where('user_id', Auth::id())
            ->whereNull('end_time')
            ->first();

        if (!$timeLog) {
            return back()->with('error', 'No running timer found for this task.');
        }

        $timeLog->stopTimer();

        return back()->with('success', 'Timer stopped successfully. Duration: ' . $timeLog->formatted_duration);
    }

    /**
     * Get task statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_tasks' => Task::count(),
            'pending_tasks' => Task::pending()->count(),
            'in_progress_tasks' => Task::inProgress()->count(),
            'completed_tasks' => Task::completed()->count(),
            'overdue_tasks' => Task::overdue()->count(),
            'urgent_tasks' => Task::byPriority('urgent')->count(),
            'tasks_due_today' => Task::dueToday()->count(),
            'tasks_due_this_week' => Task::dueThisWeek()->count(),
        ];

        // Get tasks by category
        $tasksByCategory = Task::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Get tasks by priority
        $tasksByPriority = Task::selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        return response()->json([
            'stats' => $stats,
            'by_category' => $tasksByCategory,
            'by_priority' => $tasksByPriority,
        ]);
    }

    /**
     * Get workload distribution
     */
    public function getWorkloadDistribution()
    {
        $workload = User::where('role', '!=', 'administrator')
            ->withCount(['assignedTasks as total_tasks' => function($query) {
                $query->whereNotIn('status', ['completed', 'cancelled']);
            }])
            ->withCount(['assignedTasks as pending_tasks' => function($query) {
                $query->where('status', 'pending');
            }])
            ->withCount(['assignedTasks as in_progress_tasks' => function($query) {
                $query->where('status', 'in_progress');
            }])
            ->get()
            ->map(function($user) {
                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'total_tasks' => $user->total_tasks,
                    'pending_tasks' => $user->pending_tasks,
                    'in_progress_tasks' => $user->in_progress_tasks,
                    'workload_percentage' => $user->total_tasks > 0 ? ($user->in_progress_tasks / $user->total_tasks) * 100 : 0,
                ];
            });

        return response()->json($workload);
    }

    /**
     * Show task reports (completed vs pending, overdue, recurring, etc.)
     */
    public function reports(Request $request)
    {
        $tasks = Task::with(['assignedTo'])->get();
        $completed = $tasks->where('status', 'completed')->count();
        $pending = $tasks->where('status', 'pending')->count();
        $inProgress = $tasks->where('status', 'in_progress')->count();
        $overdue = $tasks->filter(fn($t) => $t->is_overdue)->count();
        $recurring = $tasks->where('is_recurring', true)->count();
        $total = $tasks->count();
        return view('admin.tasks.reports', compact('tasks', 'completed', 'pending', 'inProgress', 'overdue', 'recurring', 'total'));
    }
}
