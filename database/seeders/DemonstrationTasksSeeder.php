<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Added this import for DB facade

class DemonstrationTasksSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Creating Demonstration Tasks for Automatic Work Distribution System');
        $this->command->info('');

        // Demo task and user seeding removed for production realism
        // $userData = [
        //     [
        //         'name' => 'Opoka Eric',
        //         'email' => 'opoka.eric@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'manufacturer',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Production Management, Quality Control',
        //         'phone' => '+256-700-000001',
        //         'address' => 'Kampala, Uganda',
        //     ],
        //     [
        //         'name' => 'Nalumansi Joyce',
        //         'email' => 'nalumansi.joyce@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'supplier',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Supplier Coordination, Procurement',
        //         'phone' => '+256-700-000002',
        //         'address' => 'Entebbe, Uganda',
        //     ],
        //     [
        //         'name' => 'Namuganza Isabella',
        //         'email' => 'namuganza.isabella@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'retailer',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Retail Management, Customer Service',
        //         'phone' => '+256-700-000003',
        //         'address' => 'Jinja, Uganda',
        //     ],
        //     [
        //         'name' => 'Brian',
        //         'email' => 'brian@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'supplier',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Logistics, Delivery',
        //         'phone' => '+256-700-000005',
        //         'address' => 'Gulu, Uganda',
        //     ],
        //     [
        //         'name' => 'Tukahebwa Ritah',
        //         'email' => 'tukahebwa.ritah@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'administrator',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Management, Administration',
        //         'phone' => '+256-700-000004',
        //         'address' => 'Mbarara, Uganda',
        //     ],
        // ];
        // foreach ($userData as $data) {
        //     \App\Models\User::updateOrCreate(['email' => $data['email']], $data);
        // }
        // Get the five demo users
        // $users = [
        //     User::where('email', 'opoka.eric@example.com')->first(),
        //     User::where('email', 'nalumansi.joyce@example.com')->first(),
        //     User::where('email', 'namuganza.isabella@example.com')->first(),
        //     User::where('email', 'tukahebwa.ritah@example.com')->first(), // admin
        //     User::where('email', 'brian@example.com')->first(),
        // ];
        // $admin = User::where('email', 'tukahebwa.ritah@example.com')->first();
        // $categories = [
        //     'manufacturer' => TaskCategory::where('name', 'Production')->first(),
        //     'supplier' => TaskCategory::where('name', 'Delivery')->first(),
        //     'retailer' => TaskCategory::where('name', 'Customer Service')->first(),
        // ];
        // $tasks = [
        //     [
        //         'title' => 'Optimize Production Line',
        //         'description' => 'Analyze and optimize the production line for efficiency.',
        //         'category' => $categories['manufacturer']?->name,
        //         'priority' => 'high',
        //         'location' => 'Kampala Factory',
        //         'contact' => 'Opoka Eric - +256-700-000001',
        //     ],
        //     [
        //         'title' => 'Supplier Coordination Meeting',
        //         'description' => 'Coordinate with suppliers for timely raw material delivery.',
        //         'category' => $categories['supplier']?->name,
        //         'priority' => 'medium',
        //         'location' => 'Entebbe Office',
        //         'contact' => 'Nalumansi Joyce - +256-700-000002',
        //     ],
        //     [
        //         'title' => 'Retail Customer Support',
        //         'description' => 'Handle customer queries and complaints at the retail outlet.',
        //         'category' => $categories['retailer']?->name,
        //         'priority' => 'medium',
        //         'location' => 'Jinja Retail Shop',
        //         'contact' => 'Namuganza Isabella - +256-700-000003',
        //     ],
        //     [
        //         'title' => 'Machine Maintenance',
        //         'description' => 'Perform scheduled maintenance on production machines.',
        //         'category' => $categories['manufacturer']?->name,
        //         'priority' => 'high',
        //         'location' => 'Mbarara Plant',
        //         'contact' => 'Tukahebwa Ritah - +256-700-000004',
        //     ],
        //     [
        //         'title' => 'Logistics and Delivery',
        //         'description' => 'Oversee logistics and ensure timely delivery to clients.',
        //         'category' => $categories['supplier']?->name,
        //         'priority' => 'high',
        //         'location' => 'Gulu Logistics Hub',
        //         'contact' => 'Brian - +256-700-000005',
        //     ],
        // ];
        // Safely reset all related tables for demo data
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // DB::table('task_assignment_audits')->truncate();
        // DB::table('task_status_audits')->truncate();
        // DB::table('task_comments')->truncate();
        // DB::table('tasks')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');
        // Create and assign tasks
        // foreach ($users as $i => $user) {
        //     if ($user && $admin && $tasks[$i]['category']) {
        //         Task::create([
        //             'title' => $tasks[$i]['title'],
        //             'description' => $tasks[$i]['description'],
        //             'assigned_by' => $admin->id,
        //             'assigned_to' => $user->id,
        //             'priority' => $tasks[$i]['priority'],
        //             'category' => $tasks[$i]['category'],
        //             'due_date' => now()->addDays(3 + $i),
        //             'start_date' => now(),
        //             'completed_at' => null,
        //             'estimated_hours' => 8,
        //             'actual_hours' => null,
        //             'progress_percentage' => 0.00,
        //             // 'notes' => 'Auto-assigned demonstration task.',
        //             // 'assignment_reason' => 'Assigned to ' . $user->name . ' (auto demo)',
        //             'is_read' => false,
        //             'visibility' => 'team',
        //             'is_recurring' => false,
        //             'recurrence_pattern' => null,
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]);
        //     }
        // }

        $this->command->info('🎉 Demonstration Complete!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('   • Total Tasks Created: ' . count(\App\Models\Task::all()));
        $this->command->info('   • Tasks Assigned: ' . \App\Models\Task::whereNotNull('assigned_to')->count());
        $this->command->info('   • Tasks Unassigned: ' . \App\Models\Task::whereNull('assigned_to')->count());
        $this->command->info('');
        $this->command->info('🔍 How to View Results:');
        $this->command->info('   1. Go to Admin → Work Distribution');
        $this->command->info('   2. View the tasks table to see automatic assignments');
        $this->command->info('   3. Check the "History" column for assignment details');
        $this->command->info('   4. Notice how tasks are assigned based on user roles and workload');
        $this->command->info('');
        $this->command->info('🧪 Test Different Scenarios:');
        $this->command->info('   • Create new tasks with different categories');
        $this->command->info('   • Change user availability status');
        $this->command->info('   • Assign more tasks to see workload balancing');
        $this->command->info('');
    }
}
