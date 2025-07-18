<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function assigned()
    {
        $tasks = Task::where('assigned_to', Auth::id())->latest()->get();
        return view('manufacturer.tasks.assigned', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);
        if ($task->assigned_to !== Auth::id()) {
            abort(403);
        }
        $task->update(['status' => $request->status]);
        return back()->with('success', 'Task status updated!');
    }
} 