<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class AutoTaskScheduler extends Command
{
    protected $signature = 'tasks:auto-schedule';
    protected $description = 'Automatically generate scheduled tasks for the system';

    public function handle()
    {
        $this->info('Starting automated task scheduling...');
        $assignedCount = 0;
        $tasks = \App\Models\Task::whereNull('assigned_to')->orWhere('assignment_method', 'auto')->where('status', 'pending')->get();
        foreach ($tasks as $task) {
            $category = \App\Models\TaskCategory::where('name', $task->category)->first();
            $assignee = $category ? $category->getBestAssignee() : null;
            if ($assignee) {
                $task->assigned_to = $assignee->id;
                $task->assignment_method = 'auto';
                $task->assignment_reason = 'Assigned to ' . $assignee->name . ' (least busy ' . ucfirst($assignee->role) . ')';
                $task->save();
                // Optionally notify the user
                $assignee->notify(new \App\Notifications\TaskStatusNotification('You have been assigned a new task: "' . $task->title . '"', $task->id));
                $assignedCount++;
            } else {
                $task->assignment_method = 'auto';
                $task->assignment_reason = 'No eligible user found';
                $task->save();
            }
        }
        $this->info("Automated scheduling complete. $assignedCount tasks assigned.");
    }
} 