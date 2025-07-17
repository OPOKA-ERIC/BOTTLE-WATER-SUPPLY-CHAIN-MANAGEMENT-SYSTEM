<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskCategory;

class TaskCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Production',
                'description' => 'Production related tasks',
                'assigned_roles' => ['manufacturer'],
                'priority' => 'high',
                'estimated_duration_hours' => 8,
                'is_active' => true,
                'color' => 'primary',
                'icon' => 'nc-icon nc-settings-gear-65',
            ],
            [
                'name' => 'Inventory',
                'description' => 'Inventory management tasks',
                'assigned_roles' => ['manufacturer', 'supplier'],
                'priority' => 'medium',
                'estimated_duration_hours' => 4,
                'is_active' => true,
                'color' => 'info',
                'icon' => 'nc-icon nc-box-2',
            ],
            [
                'name' => 'Delivery',
                'description' => 'Delivery and logistics tasks',
                'assigned_roles' => ['supplier', 'retailer', 'deliverer'],
                'priority' => 'high',
                'estimated_duration_hours' => 6,
                'is_active' => true,
                'color' => 'success',
                'icon' => 'nc-icon nc-delivery-fast',
            ],
            [
                'name' => 'Quality Control',
                'description' => 'Quality assurance and control tasks',
                'assigned_roles' => ['manufacturer', 'quality_controller'],
                'priority' => 'urgent',
                'estimated_duration_hours' => 2,
                'is_active' => true,
                'color' => 'danger',
                'icon' => 'nc-icon nc-check-2',
            ],
            [
                'name' => 'Customer Service',
                'description' => 'Customer support and service tasks',
                'assigned_roles' => ['retailer', 'customer_service'],
                'priority' => 'medium',
                'estimated_duration_hours' => 3,
                'is_active' => true,
                'color' => 'warning',
                'icon' => 'nc-icon nc-support-17',
            ],
            [
                'name' => 'Supplier',
                'description' => 'Supplier management and coordination tasks',
                'assigned_roles' => ['supplier'],
                'priority' => 'medium',
                'estimated_duration_hours' => 5,
                'is_active' => true,
                'color' => 'secondary',
                'icon' => 'nc-icon nc-delivery-fast',
            ],
            [
                'name' => 'Retailer',
                'description' => 'Retailer order and stock management tasks',
                'assigned_roles' => ['retailer'],
                'priority' => 'medium',
                'estimated_duration_hours' => 4,
                'is_active' => true,
                'color' => 'primary',
                'icon' => 'nc-icon nc-shop',
            ],
            [
                'name' => 'Deliverer',
                'description' => 'Tasks for delivery personnel',
                'assigned_roles' => ['deliverer'],
                'priority' => 'high',
                'estimated_duration_hours' => 6,
                'is_active' => true,
                'color' => 'success',
                'icon' => 'nc-icon nc-truck',
            ],
            [
                'name' => 'Manufacturer',
                'description' => 'Tasks for manufacturing staff',
                'assigned_roles' => ['manufacturer'],
                'priority' => 'high',
                'estimated_duration_hours' => 8,
                'is_active' => true,
                'color' => 'info',
                'icon' => 'nc-icon nc-industry',
            ],
            [
                'name' => 'Procurement',
                'description' => 'Procurement and purchasing tasks',
                'assigned_roles' => ['procurement'],
                'priority' => 'medium',
                'estimated_duration_hours' => 5,
                'is_active' => true,
                'color' => 'dark',
                'icon' => 'nc-icon nc-cart-simple',
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Equipment and facility maintenance tasks',
                'assigned_roles' => ['maintenance'],
                'priority' => 'medium',
                'estimated_duration_hours' => 4,
                'is_active' => true,
                'color' => 'secondary',
                'icon' => 'nc-icon nc-settings-gear-64',
            ],
            [
                'name' => 'Admin',
                'description' => 'Administrative and management tasks',
                'assigned_roles' => ['administrator'],
                'priority' => 'medium',
                'estimated_duration_hours' => 3,
                'is_active' => true,
                'color' => 'light',
                'icon' => 'nc-icon nc-single-02',
            ],
        ];

        foreach ($categories as $cat) {
            TaskCategory::updateOrCreate(
                ['name' => $cat['name']],
                [
                    'description' => $cat['description'],
                    'assigned_roles' => $cat['assigned_roles'],
                    'priority' => $cat['priority'],
                    'estimated_duration_hours' => $cat['estimated_duration_hours'],
                    'is_active' => $cat['is_active'],
                    'color' => $cat['color'],
                    'icon' => $cat['icon'],
                ]
            );
        }
    }
} 