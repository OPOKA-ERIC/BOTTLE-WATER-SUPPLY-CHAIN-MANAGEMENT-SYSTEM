<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RealUsersAndTasksSeeder extends Seeder
{
    public function run(): void
    {
        // Seed real users
        $users = [
            [
                'name' => 'Opoka Eric',
                'email' => 'opoka.eric@example.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturer',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Production Management, Quality Control',
                'phone' => '+256-700-000001',
                'address' => 'Kampala, Uganda',
            ],
            [
                'name' => 'Brian',
                'email' => 'brian@example.com',
                'password' => Hash::make('password'),
                'role' => 'supplier',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Logistics, Delivery',
                'phone' => '+256-700-000005',
                'address' => 'Gulu, Uganda',
            ],
            [
                'name' => 'Nalumansi Joyce',
                'email' => 'nalumansi.joyce@example.com',
                'password' => Hash::make('password'),
                'role' => 'supplier',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Supplier Coordination, Procurement',
                'phone' => '+256-700-000002',
                'address' => 'Entebbe, Uganda',
            ],
            [
                'name' => 'Namuganza Isabella',
                'email' => 'namuganza.isabella@example.com',
                'password' => Hash::make('password'),
                'role' => 'retailer',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Retail Management, Customer Service',
                'phone' => '+256-700-000003',
                'address' => 'Jinja, Uganda',
            ],
            [
                'name' => 'Tukahebwa Ritah',
                'email' => 'tukahebwa.ritah@example.com',
                'password' => Hash::make('password'),
                'role' => 'administrator',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Management, Administration',
                'phone' => '+256-700-000004',
                'address' => 'Mbarara, Uganda',
            ],
            [
                'name' => 'Mugisha Samuel',
                'email' => 'mugisha.samuel@example.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturer',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Production, Maintenance',
                'phone' => '+256-700-000006',
                'address' => 'Fort Portal, Uganda',
            ],
            [
                'name' => 'Achan Grace',
                'email' => 'achan.grace@example.com',
                'password' => Hash::make('password'),
                'role' => 'retailer',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Sales, Customer Service',
                'phone' => '+256-700-000007',
                'address' => 'Arua, Uganda',
            ],
        ];
        foreach ($users as $data) {
            User::updateOrCreate(['email' => $data['email']], $data);
        }

        // Get admin and users for assignment
        $admin = User::where('email', 'tukahebwa.ritah@example.com')->first();
        $eric = User::where('email', 'opoka.eric@example.com')->first();
        $brian = User::where('email', 'brian@example.com')->first();
        $joyce = User::where('email', 'nalumansi.joyce@example.com')->first();
        $isabella = User::where('email', 'namuganza.isabella@example.com')->first();
        $samuel = User::where('email', 'mugisha.samuel@example.com')->first();
        $grace = User::where('email', 'achan.grace@example.com')->first();

        // Get categories
        $production = TaskCategory::where('name', 'Production')->first();
        $delivery = TaskCategory::where('name', 'Delivery')->first();
        $customerService = TaskCategory::where('name', 'Customer Service')->first();
        $maintenance = TaskCategory::where('name', 'Maintenance')->first();

        // Seed realistic tasks
        $tasks = [
            [
                'title' => 'Start Today\'s Production Batch',
                'description' => 'Begin the scheduled production batch for bottled water.',
                'assigned_by' => $admin?->id,
                'assigned_to' => $eric?->id,
                'priority' => 'high',
                'category' => $production?->name,
                'due_date' => Carbon::now()->addDay(),
                'status' => 'pending',
                'assignment_method' => 'auto',
                'assignment_reason' => 'Auto-assigned to least busy manufacturer',
                'location' => 'Kampala Factory',
                'contact' => 'Opoka Eric - +256-700-000001',
                'is_read' => false,
            ],
            [
                'title' => 'Deliver Raw Materials',
                'description' => 'Deliver raw materials to the production site before noon.',
                'assigned_by' => $admin?->id,
                'assigned_to' => $brian?->id,
                'priority' => 'medium',
                'category' => $delivery?->name,
                'due_date' => Carbon::now()->addDays(2),
                'status' => 'pending',
                'assignment_method' => 'manual',
                'assignment_reason' => 'Assigned by Admin',
                'location' => 'Gulu Logistics Hub',
                'contact' => 'Brian - +256-700-000005',
                'is_read' => false,
            ],
            [
                'title' => 'Supplier Coordination',
                'description' => 'Coordinate with suppliers for next week\'s delivery.',
                'assigned_by' => $admin?->id,
                'assigned_to' => $joyce?->id,
                'priority' => 'medium',
                'category' => $delivery?->name,
                'due_date' => Carbon::now()->addDays(3),
                'status' => 'pending',
                'assignment_method' => 'manual',
                'assignment_reason' => 'Assigned by Admin',
                'location' => 'Entebbe Office',
                'contact' => 'Nalumansi Joyce - +256-700-000002',
                'is_read' => false,
            ],
            [
                'title' => 'Retail Customer Support',
                'description' => 'Handle customer queries and complaints at the retail outlet.',
                'assigned_by' => $admin?->id,
                'assigned_to' => $isabella?->id,
                'priority' => 'medium',
                'category' => $customerService?->name,
                'due_date' => Carbon::now()->addDays(2),
                'status' => 'pending',
                'assignment_method' => 'auto',
                'assignment_reason' => 'Auto-assigned to least busy retailer',
                'location' => 'Jinja Retail Shop',
                'contact' => 'Namuganza Isabella - +256-700-000003',
                'is_read' => false,
            ],
            [
                'title' => 'Machine Maintenance',
                'description' => 'Perform scheduled maintenance on production machines.',
                'assigned_by' => $admin?->id,
                'assigned_to' => $samuel?->id,
                'priority' => 'high',
                'category' => $maintenance?->name,
                'due_date' => Carbon::now()->addDays(4),
                'status' => 'pending',
                'assignment_method' => 'manual',
                'assignment_reason' => 'Assigned by Admin',
                'location' => 'Fort Portal Plant',
                'contact' => 'Mugisha Samuel - +256-700-000006',
                'is_read' => false,
            ],
            [
                'title' => 'Retail Sales Support',
                'description' => 'Assist with sales and customer support at Arua branch.',
                'assigned_by' => $admin?->id,
                'assigned_to' => $grace?->id,
                'priority' => 'low',
                'category' => $customerService?->name,
                'due_date' => Carbon::now()->addDays(3),
                'status' => 'pending',
                'assignment_method' => 'auto',
                'assignment_reason' => 'Auto-assigned to least busy retailer',
                'location' => 'Arua Branch',
                'contact' => 'Achan Grace - +256-700-000007',
                'is_read' => false,
            ],
        ];
        foreach ($tasks as $data) {
            if ($data['assigned_by'] && $data['assigned_to'] && $data['category']) {
                Task::create($data);
            }
        }
    }
} 