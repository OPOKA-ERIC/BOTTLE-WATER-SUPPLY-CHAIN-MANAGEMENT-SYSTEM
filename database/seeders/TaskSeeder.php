<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for assignment (excluding admin)
        $users = User::where('role', '!=', 'administrator')->get();
        $admin = User::where('role', 'administrator')->first();

        if ($users->isEmpty() || !$admin) {
            $this->command->warn('No users found for task assignment. Please run UserSeeder first.');
            return;
        }

        // Get specific users by role for targeted assignments
        $productionManager = $users->where('role', 'manufacturer')->where('name', 'Michael Chen')->first();
        $qualityControl = $users->where('role', 'manufacturer')->where('name', 'Dr. Emily Rodriguez')->first();
        $logisticsCoordinator = $users->where('role', 'supplier')->where('name', 'David Thompson')->first();
        $deliveryDriver = $users->where('role', 'supplier')->where('name', 'James Wilson')->first();
        $retailManager = $users->where('role', 'retailer')->where('name', 'Lisa Anderson')->first();
        $inventorySpecialist = $users->where('role', 'manufacturer')->where('name', 'Robert Martinez')->first();
        $maintenanceTech = $users->where('role', 'manufacturer')->where('name', 'Kevin O\'Brien')->first();
        $customerService = $users->where('role', 'retailer')->where('name', 'Amanda Foster')->first();
        $distributionCoordinator = $users->where('role', 'supplier')->where('name', 'Carlos Mendez')->first();

        $taskData = [
            // Quality Control Tasks - Assigned to Dr. Emily Rodriguez
            [
                'title' => 'Water Quality Testing - Production Line A',
                'description' => 'Conduct comprehensive water quality testing on production line A. Test for pH levels, mineral content, chlorine levels, and bacterial contamination. Ensure compliance with FDA standards for bottled water.',
                'priority' => 'high',
                'category' => 'quality_control',
                'due_date' => Carbon::now()->addDays(1),
                'estimated_hours' => 6,
                'location' => 'Quality Control Lab - Line A',
                'notes' => 'Use new testing equipment. Document all readings and prepare compliance report.',
                'assigned_to' => $qualityControl->id,
            ],
            [
                'title' => 'Bottle Seal Integrity Inspection',
                'description' => 'Perform seal integrity testing on 500ml and 1L bottles. Check for proper sealing, leak detection, and tamper-evident features. Test both PET and glass bottle variants.',
                'priority' => 'high',
                'category' => 'quality_control',
                'due_date' => Carbon::now()->addDays(2),
                'estimated_hours' => 4,
                'location' => 'Quality Control Lab - Sealing Station',
                'notes' => 'Focus on new bottle design. Report any seal failures immediately.',
                'assigned_to' => $qualityControl->id,
            ],
            [
                'title' => 'Label Compliance Audit',
                'description' => 'Audit all product labels for FDA compliance. Verify nutritional information, ingredient lists, expiration dates, and barcode accuracy. Check for proper allergen warnings.',
                'priority' => 'medium',
                'category' => 'quality_control',
                'due_date' => Carbon::now()->addDays(3),
                'estimated_hours' => 5,
                'location' => 'Quality Control Office',
                'notes' => 'Include new flavored water variants in audit.',
                'assigned_to' => $qualityControl->id,
            ],

            // Production Tasks - Assigned to Michael Chen
            [
                'title' => 'Production Line Optimization - Bottling Unit #2',
                'description' => 'Optimize production line #2 for maximum efficiency. Analyze current bottlenecks, adjust conveyor speeds, and calibrate filling machines for consistent bottle fill levels.',
                'priority' => 'high',
                'category' => 'production',
                'due_date' => Carbon::now()->addDays(2),
                'estimated_hours' => 8,
                'location' => 'Production Floor - Line #2',
                'notes' => 'Target 95% efficiency rate. Monitor water consumption during optimization.',
                'assigned_to' => $productionManager->id,
            ],
            [
                'title' => 'Weekly Production Schedule Planning',
                'description' => 'Plan next week\'s production schedule based on current orders and inventory levels. Coordinate with suppliers for raw materials and schedule maintenance windows.',
                'priority' => 'high',
                'category' => 'production',
                'due_date' => Carbon::now()->addDays(1),
                'estimated_hours' => 6,
                'location' => 'Production Planning Office',
                'notes' => 'Consider upcoming holiday demand and supplier availability.',
                'assigned_to' => $productionManager->id,
            ],
            [
                'title' => 'New Product Line Setup - Sparkling Water',
                'description' => 'Set up new production line for sparkling water products. Install carbonation equipment, calibrate filling machines, and train operators on new procedures.',
                'priority' => 'medium',
                'category' => 'production',
                'due_date' => Carbon::now()->addDays(7),
                'estimated_hours' => 12,
                'location' => 'Production Floor - New Line',
                'notes' => 'Coordinate with quality control for initial testing.',
                'assigned_to' => $productionManager->id,
            ],

            // Maintenance Tasks - Assigned to Kevin O'Brien
            [
                'title' => 'Bottling Machine Preventive Maintenance',
                'description' => 'Perform scheduled preventive maintenance on all bottling machines. Replace worn parts, lubricate moving components, and calibrate sensors for optimal performance.',
                'priority' => 'medium',
                'category' => 'maintenance',
                'due_date' => Carbon::now()->addDays(3),
                'estimated_hours' => 8,
                'location' => 'Production Floor - All Machines',
                'notes' => 'Check hydraulic systems and replace filters as needed.',
                'assigned_to' => $maintenanceTech->id,
            ],
            [
                'title' => 'Water Filtration System Maintenance',
                'description' => 'Service and clean water filtration systems. Replace filter cartridges, check UV sterilization units, and test water quality at various filtration stages.',
                'priority' => 'high',
                'category' => 'maintenance',
                'due_date' => Carbon::now()->addDays(1),
                'estimated_hours' => 6,
                'location' => 'Water Treatment Facility',
                'notes' => 'Critical for water quality. Document all maintenance activities.',
                'assigned_to' => $maintenanceTech->id,
            ],
            [
                'title' => 'Conveyor System Repair',
                'description' => 'Repair malfunctioning conveyor system on production line #3. Replace damaged belts, adjust tension, and ensure smooth bottle transport.',
                'priority' => 'urgent',
                'category' => 'maintenance',
                'due_date' => Carbon::now()->addHours(4),
                'estimated_hours' => 4,
                'location' => 'Production Floor - Line #3',
                'notes' => 'Production line currently down. Priority repair needed.',
                'assigned_to' => $maintenanceTech->id,
            ],

            // Inventory Tasks - Assigned to Robert Martinez
            [
                'title' => 'Raw Materials Inventory Count',
                'description' => 'Conduct physical inventory count of all raw materials. Verify PET preforms, bottle caps, labels, and packaging materials against system records.',
                'priority' => 'medium',
                'category' => 'inventory',
                'due_date' => Carbon::now()->addDays(2),
                'estimated_hours' => 8,
                'location' => 'Raw Materials Warehouse',
                'notes' => 'Use barcode scanners for accuracy. Report any discrepancies.',
                'assigned_to' => $inventorySpecialist->id,
            ],
            [
                'title' => 'Finished Goods Inventory Audit',
                'description' => 'Audit finished goods inventory in all warehouses. Count bottled water products by size and type, check expiration dates, and verify storage conditions.',
                'priority' => 'medium',
                'category' => 'inventory',
                'due_date' => Carbon::now()->addDays(4),
                'estimated_hours' => 10,
                'location' => 'Finished Goods Warehouses',
                'notes' => 'Include temperature monitoring and pallet condition checks.',
                'assigned_to' => $inventorySpecialist->id,
            ],
            [
                'title' => 'Supplier Order Processing',
                'description' => 'Process orders for raw materials from suppliers. Verify pricing, quantities, and delivery schedules. Coordinate with production planning.',
                'priority' => 'high',
                'category' => 'inventory',
                'due_date' => Carbon::now()->addDays(1),
                'estimated_hours' => 4,
                'location' => 'Procurement Office',
                'notes' => 'Ensure timely delivery to avoid production delays.',
                'assigned_to' => $inventorySpecialist->id,
            ],

            // Logistics & Delivery Tasks - Assigned to David Thompson & James Wilson
            [
                'title' => 'Delivery Route Optimization',
                'description' => 'Optimize delivery routes for better efficiency and reduced fuel costs. Analyze current routes, identify bottlenecks, and implement GPS-based route planning.',
                'priority' => 'medium',
                'category' => 'delivery',
                'due_date' => Carbon::now()->addDays(5),
                'estimated_hours' => 6,
                'location' => 'Logistics Office',
                'notes' => 'Use GPS tracking data from last month for analysis.',
                'assigned_to' => $logisticsCoordinator->id,
            ],
            [
                'title' => 'Fleet Vehicle Maintenance Schedule',
                'description' => 'Schedule maintenance for all delivery vehicles. Coordinate with service providers, track maintenance history, and ensure vehicles meet safety standards.',
                'priority' => 'medium',
                'category' => 'delivery',
                'due_date' => Carbon::now()->addDays(3),
                'estimated_hours' => 4,
                'location' => 'Fleet Management Office',
                'notes' => 'Include safety inspections and driver training updates.',
                'assigned_to' => $logisticsCoordinator->id,
            ],
            [
                'title' => 'Express Delivery - Premium Customer',
                'description' => 'Handle express delivery for premium customer order. Ensure proper handling, temperature control, and on-time delivery to maintain customer satisfaction.',
                'priority' => 'urgent',
                'category' => 'delivery',
                'due_date' => Carbon::now()->addHours(6),
                'estimated_hours' => 3,
                'location' => 'Premium Customer Location',
                'notes' => 'Premium account - handle with extra care.',
                'assigned_to' => $deliveryDriver->id,
            ],
            [
                'title' => 'Bulk Order Delivery - Retail Chain',
                'description' => 'Deliver bulk order to major retail chain. Coordinate with warehouse for loading, ensure proper documentation, and handle delivery confirmation.',
                'priority' => 'high',
                'category' => 'delivery',
                'due_date' => Carbon::now()->addDays(2),
                'estimated_hours' => 5,
                'location' => 'Retail Chain Distribution Center',
                'notes' => 'Large order - coordinate with multiple drivers if needed.',
                'assigned_to' => $deliveryDriver->id,
            ],

            // Retail & Customer Service Tasks - Assigned to Lisa Anderson & Amanda Foster
            [
                'title' => 'Retail Account Management - Major Chain',
                'description' => 'Manage relationship with major retail chain. Review sales performance, discuss promotional opportunities, and address any service issues.',
                'priority' => 'high',
                'category' => 'customer_service',
                'due_date' => Carbon::now()->addDays(2),
                'estimated_hours' => 4,
                'location' => 'Retail Chain Headquarters',
                'notes' => 'Quarterly review meeting. Prepare sales reports and proposals.',
                'assigned_to' => $retailManager->id,
            ],
            [
                'title' => 'Customer Complaint Resolution',
                'description' => 'Resolve customer complaint about damaged bottles in recent delivery. Contact customer, arrange replacement, and investigate cause of damage.',
                'priority' => 'urgent',
                'category' => 'customer_service',
                'due_date' => Carbon::now()->addHours(2),
                'estimated_hours' => 2,
                'location' => 'Customer Service Office',
                'notes' => 'Premium customer - handle with priority.',
                'assigned_to' => $customerService->id,
            ],
            [
                'title' => 'New Retail Account Onboarding',
                'description' => 'Onboard new retail account. Set up ordering system, provide product training, and establish delivery schedule.',
                'priority' => 'medium',
                'category' => 'customer_service',
                'due_date' => Carbon::now()->addDays(5),
                'estimated_hours' => 6,
                'location' => 'New Retail Location',
                'notes' => 'Include product placement and promotional material setup.',
                'assigned_to' => $retailManager->id,
            ],

            // Distribution Tasks - Assigned to Carlos Mendez
            [
                'title' => 'Regional Distribution Center Setup',
                'description' => 'Set up new regional distribution center. Coordinate with contractors, install equipment, and establish operational procedures.',
                'priority' => 'medium',
                'category' => 'delivery',
                'due_date' => Carbon::now()->addDays(14),
                'estimated_hours' => 16,
                'location' => 'New Regional Distribution Center',
                'notes' => 'Coordinate with logistics team for equipment installation.',
                'assigned_to' => $distributionCoordinator->id,
            ],
            [
                'title' => 'Distribution Network Analysis',
                'description' => 'Analyze current distribution network performance. Identify areas for improvement, cost optimization opportunities, and expansion possibilities.',
                'priority' => 'low',
                'category' => 'delivery',
                'due_date' => Carbon::now()->addDays(10),
                'estimated_hours' => 8,
                'location' => 'Distribution Planning Office',
                'notes' => 'Use data from last quarter for analysis.',
                'assigned_to' => $distributionCoordinator->id,
            ],
        ];

        foreach ($taskData as $task) {
            $status = $this->getRandomStatus();
            $actualHours = $status === 'completed' ? $this->getRandomActualHours($task['estimated_hours']) : null;
            $progress = $this->getRandomProgress();
            $startDate = $status !== 'pending' ? Carbon::now()->subDays(rand(1, 10)) : null;
            $completedAt = $status === 'completed' ? Carbon::now()->subDays(rand(1, 5)) : null;

            Task::create([
                'title' => $task['title'],
                'description' => $task['description'],
                'assigned_by' => $admin->id,
                'assigned_to' => $task['assigned_to'],
                'priority' => $task['priority'],
                'status' => $status,
                'category' => $task['category'],
                'due_date' => $task['due_date'],
                'start_date' => $startDate,
                'completed_at' => $completedAt,
                'estimated_hours' => $task['estimated_hours'],
                'actual_hours' => $actualHours,
                'progress_percentage' => $progress,
                'notes' => $task['notes'],
                'location' => $task['location'],
                'visibility' => 'team',
                'is_recurring' => false,
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 5)),
            ]);
        }

        $this->command->info('Tasks seeded successfully with realistic bottle water industry assignments!');
    }

    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $weights = [30, 40, 25, 5]; // 30% pending, 40% in_progress, 25% completed, 5% cancelled
        
        $random = rand(1, 100);
        $cumulative = 0;
        
        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $statuses[$index];
            }
        }
        
        return 'pending';
    }

    private function getRandomActualHours(int $estimatedHours): ?int
    {
        // Actual hours can be 80% to 120% of estimated hours
        $min = max(1, (int)($estimatedHours * 0.8));
        $max = (int)($estimatedHours * 1.2);
        return rand($min, $max);
    }

    private function getRandomProgress(): float
    {
        $progresses = [0, 25, 50, 75, 100];
        return $progresses[array_rand($progresses)];
    }
}
