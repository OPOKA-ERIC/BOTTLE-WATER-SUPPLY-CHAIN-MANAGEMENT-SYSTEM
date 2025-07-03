<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // Administrator
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'administrator',
                'status' => 'active',
                'phone' => '+1-555-0101',
                'address' => '123 Corporate Plaza, Suite 200, New York, NY 10001',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Production Manager
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'manufacturer',
                'status' => 'active',
                'phone' => '+1-555-0102',
                'address' => '456 Production Ave, Factory District, NY 10002',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Quality Control Specialist
            [
                'name' => 'Dr. Emily Rodriguez',
                'email' => 'emily.rodriguez@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'manufacturer',
                'status' => 'active',
                'phone' => '+1-555-0103',
                'address' => '789 Quality Lane, Lab Building, NY 10003',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Logistics Coordinator
            [
                'name' => 'David Thompson',
                'email' => 'david.thompson@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'supplier',
                'status' => 'active',
                'phone' => '+1-555-0104',
                'address' => '321 Logistics Way, Warehouse Complex, NY 10004',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Delivery Driver
            [
                'name' => 'James Wilson',
                'email' => 'james.wilson@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'supplier',
                'status' => 'active',
                'phone' => '+1-555-0105',
                'address' => '654 Driver Street, Transport Hub, NY 10005',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Retail Account Manager
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'retailer',
                'status' => 'active',
                'phone' => '+1-555-0106',
                'address' => '987 Retail Blvd, Sales Office, NY 10006',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Inventory Specialist
            [
                'name' => 'Robert Martinez',
                'email' => 'robert.martinez@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'manufacturer',
                'status' => 'active',
                'phone' => '+1-555-0107',
                'address' => '147 Inventory Road, Storage Facility, NY 10007',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Maintenance Technician
            [
                'name' => 'Kevin O\'Brien',
                'email' => 'kevin.obrien@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'manufacturer',
                'status' => 'active',
                'phone' => '+1-555-0108',
                'address' => '258 Maintenance Drive, Equipment Bay, NY 10008',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Customer Service Representative
            [
                'name' => 'Amanda Foster',
                'email' => 'amanda.foster@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'retailer',
                'status' => 'active',
                'phone' => '+1-555-0109',
                'address' => '369 Service Center, Customer Care Building, NY 10009',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Distribution Coordinator
            [
                'name' => 'Carlos Mendez',
                'email' => 'carlos.mendez@aquapure.com',
                'password' => Hash::make('password123'),
                'role' => 'supplier',
                'status' => 'active',
                'phone' => '+1-555-0110',
                'address' => '741 Distribution Ave, Regional Hub, NY 10010',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
