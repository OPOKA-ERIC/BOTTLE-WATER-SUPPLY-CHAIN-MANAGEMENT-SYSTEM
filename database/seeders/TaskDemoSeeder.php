<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskFeedback;
use App\Models\TaskReview;

class TaskDemoSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('role', '!=', 'administrator')->first();
        $admin = User::where('role', 'administrator')->first();

        if ($user && $admin) {
            $task = Task::create([
                'title' => 'Water Quality Check',
                'description' => 'Check water quality for batch 2025-07-16',
                'assigned_by' => $admin->id,
                'assigned_to' => $user->id,
                'priority' => 'high',
                'category' => 'quality_control',
                'due_date' => now()->addDay(),
                'location' => 'Plant B',
                'contact' => '987654321',
                'status' => 'completed',
                'assignment_method' => 'auto',
                'assignment_reason' => 'Routine quality check',
                'is_read' => false,
            ]);

            TaskFeedback::create([
                'task_id' => $task->id,
                'user_id' => $user->id,
                'feedback' => 'All procedures were clear and the equipment was available.',
            ]);

            TaskReview::create([
                'task_id' => $task->id,
                'supervisor_id' => $admin->id,
                'rating' => 5,
                'review' => 'Excellent attention to detail and timely completion.',
            ]);
        }
    }
} 