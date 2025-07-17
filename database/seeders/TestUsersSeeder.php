<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove all previous test users for this demo
        \App\Models\User::whereIn('email', [
            'opoka.eric@example.com',
            'nalumansi.joyce@example.com',
            'namuganza.isabella@example.com',
            'tukahebwa.ritah@example.com',
            'brian@example.com',
            'ademo.demo@example.com', // ensure clean slate
        ])->delete();
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
                'role' => 'manufacturer',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Maintenance, Production Management',
                'phone' => '+256-700-000004',
                'address' => 'Mbarara, Uganda',
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
                'name' => 'ademo demo',
                'email' => 'ademo.demo@example.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturer',
                'status' => 'active',
                'is_available' => true,
                'skills' => 'Production Management, Quality Control, Logistics, Customer Service, Procurement, Maintenance, Retail Management, Supplier Coordination, Delivery, Administration',
                'phone' => '+1-555-9999',
                'address' => '100 Demo Lane, Test City',
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
        $this->command->info('Test users created successfully!');
    }
}
