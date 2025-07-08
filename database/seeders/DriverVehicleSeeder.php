<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;

class DriverVehicleSeeder extends Seeder
{
    public function run()
    {
        // Create sample drivers
        $drivers = [
            [
                'name' => 'John Driver',
                'email' => 'john.driver@bwscms.com',
                'password' => Hash::make('password'),
                'role' => 'driver',
                'status' => 'active',
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@bwscms.com',
                'password' => Hash::make('password'),
                'role' => 'driver',
                'status' => 'active',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@bwscms.com',
                'password' => Hash::make('password'),
                'role' => 'driver',
                'status' => 'active',
            ],
        ];

        foreach ($drivers as $driver) {
            User::create($driver);
        }

        // Create sample vehicles
        $vehicles = [
            [
                'plate_number' => 'UAA 123A',
                'model' => 'Toyota Hiace',
                'type' => 'Van',
                'status' => 'available',
            ],
            [
                'plate_number' => 'UAB 456B',
                'model' => 'Isuzu NPR',
                'type' => 'Truck',
                'status' => 'available',
            ],
            [
                'plate_number' => 'UAC 789C',
                'model' => 'Ford Transit',
                'type' => 'Van',
                'status' => 'available',
            ],
            [
                'plate_number' => 'UAD 012D',
                'model' => 'Mitsubishi Fuso',
                'type' => 'Truck',
                'status' => 'available',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }

        $this->command->info('Drivers and vehicles seeded successfully!');
    }
} 