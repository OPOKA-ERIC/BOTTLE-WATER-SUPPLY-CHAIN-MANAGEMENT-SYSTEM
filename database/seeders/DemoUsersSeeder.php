<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Demo users removed for production realism
        // $users = [
        //     [
        //         'name' => 'Demo Manufacturer',
        //         'email' => 'manufacturer.demo@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'manufacturer',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Production, Quality Control',
        //         'phone' => '+256-700-000101',
        //         'address' => 'Kampala, Uganda',
        //     ],
        //     [
        //         'name' => 'Demo Supplier',
        //         'email' => 'supplier.demo@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'supplier',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Procurement, Logistics',
        //         'phone' => '+256-700-000102',
        //         'address' => 'Entebbe, Uganda',
        //     ],
        //     [
        //         'name' => 'Demo Retailer',
        //         'email' => 'retailer.demo@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'retailer',
        //         'status' => 'active',
        //         'is_available' => true,
        //         'skills' => 'Sales, Customer Service',
        //         'phone' => '+256-700-000103',
        //         'address' => 'Jinja, Uganda',
        //     ],
        // ];
        // foreach ($users as $data) {
        //     User::updateOrCreate(['email' => $data['email']], $data);
        // }
    }
} 