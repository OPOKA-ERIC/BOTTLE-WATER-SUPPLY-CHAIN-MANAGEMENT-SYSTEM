<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Notifications\TaskStatusNotification;
use Carbon\Carbon;

class DistributeThreeTasksSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('email', [
            'manufacturer.demo@example.com',
            'supplier.demo@example.com',
            'retailer.demo@example.com',
        ])->get();

        $taskData = [
            [
                'title' => 'Production Task',
                'description' => 'Manage today\'s production batch.',
                'priority' => 'high',
                'category' => 'Production',
                'location' => 'Factory',
            ],
            [
                'title' => 'Supply Task',
                'description' => 'Deliver raw materials to manufacturer.',
                'priority' => 'medium',
                'category' => 'Supplier',
                'location' => 'Warehouse',
            ],
            [
                'title' => 'Retail Task',
                'description' => 'Stock new products in store.',
                'priority' => 'low',
                'category' => 'Retailer',
                'location' => 'Retail Shop',
            ],
        ];

        foreach ($users as $i => $user) {
            $data = $taskData[$i];
            $task = Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'assigned_by' => 1,
                'assigned_to' => $user->id,
                'priority' => $data['priority'],
                'category' => $data['category'],
                'due_date' => Carbon::now()->addDays($i + 2),
                'status' => 'in_progress',
                'assignment_method' => 'auto',
                'assignment_reason' => 'Seeder assignment for demo',
                'location' => $data['location'],
                'contact' => $user->email,
                'is_read' => false,
            ]);
            $user->notify(new TaskStatusNotification([
                'message' => 'You have been assigned a new task: ' . $task->title . ' and it is now in progress.',
                'title' => $task->title,
                'task_id' => $task->id
            ], $task->id));
        }
    }
} 