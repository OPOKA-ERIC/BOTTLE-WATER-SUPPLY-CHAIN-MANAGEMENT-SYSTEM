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
        $today = Carbon::today();
        $created = 0;

        // Example 1: Auto-create a "Repatch Order" task for each delivery agent if there are pending orders (dummy logic)
        $deliveryAgents = User::where('role', 'delivery_agent')->get();
        foreach ($deliveryAgents as $agent) {
            // Dummy condition: always create a repatch order task for demo
            Task::create([
                'title' => 'Repatch Order',
                'description' => 'Automatically generated repatch order for delivery agent.',
                'assigned_by' => 1, // System/admin user
                'assigned_to' => $agent->id,
                'priority' => 'high',
                'category' => 'delivery',
                'status' => 'pending',
                'due_date' => $today->copy()->addDay(),
            ]);
            $created++;
        }

        // Example 2: Auto-create a "Send Daily Report" task for all administrators
        $admins = User::where('role', 'administrator')->get();
        foreach ($admins as $admin) {
            Task::create([
                'title' => 'Send Daily Report',
                'description' => 'Automatically generated daily report task.',
                'assigned_by' => 1, // System/admin user
                'assigned_to' => $admin->id,
                'priority' => 'medium',
                'category' => 'admin',
                'status' => 'pending',
                'due_date' => $today->copy()->addDay(),
            ]);
            $created++;
        }

        $this->info("Auto-scheduled $created tasks.");
    }
} 