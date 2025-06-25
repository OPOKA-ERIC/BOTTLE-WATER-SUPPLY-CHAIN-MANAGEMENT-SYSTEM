<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get manufacturer users
        $manufacturers = User::where('role', 'manufacturer')->get();
        
        if ($manufacturers->isEmpty()) {
            $this->command->info('No manufacturer users found. Creating sample notifications skipped.');
            return;
        }
        
        foreach ($manufacturers as $manufacturer) {
            // Create sample notifications
            $notifications = [
                [
                    'title' => 'Low Inventory Alert',
                    'message' => 'Plastic bottles inventory is running low. Current stock: 1,250 units. Reorder recommended to maintain production schedule.',
                    'type' => 'warning',
                    'priority' => 'high',
                    'is_read' => false,
                    'data' => ['inventory_id' => 1, 'current_stock' => 1250, 'reorder_point' => 2000]
                ],
                [
                    'title' => 'Production Target Achieved',
                    'message' => 'Monthly production target of 15,000 units has been achieved ahead of schedule. Great work team!',
                    'type' => 'success',
                    'priority' => 'medium',
                    'is_read' => true,
                    'data' => ['target' => 15000, 'achieved' => 15250, 'percentage' => 101.7]
                ],
                [
                    'title' => 'Efficiency Report Available',
                    'message' => 'Weekly efficiency report is now available. Production efficiency increased by 8.2% compared to last week.',
                    'type' => 'info',
                    'priority' => 'low',
                    'is_read' => false,
                    'data' => ['efficiency_increase' => 8.2, 'report_period' => 'weekly']
                ],
                [
                    'title' => 'Equipment Maintenance Due',
                    'message' => 'Bottling machine #3 requires scheduled maintenance. Please schedule maintenance within the next 48 hours.',
                    'type' => 'warning',
                    'priority' => 'medium',
                    'is_read' => false,
                    'data' => ['equipment_id' => 3, 'maintenance_type' => 'scheduled', 'due_hours' => 48]
                ],
                [
                    'title' => 'Quality Check Passed',
                    'message' => 'Batch #2024-045 has passed all quality control tests. Ready for packaging and distribution.',
                    'type' => 'success',
                    'priority' => 'low',
                    'is_read' => true,
                    'data' => ['batch_id' => '2024-045', 'quality_score' => 98.5]
                ],
                [
                    'title' => 'New Order Received',
                    'message' => 'New order #ORD-2024-001 for 5,000 units of 500ml bottles from Retailer ABC. Due date: 2024-07-15.',
                    'type' => 'info',
                    'priority' => 'medium',
                    'is_read' => false,
                    'data' => ['order_id' => 'ORD-2024-001', 'quantity' => 5000, 'due_date' => '2024-07-15']
                ],
                [
                    'title' => 'Raw Material Delivery',
                    'message' => 'Raw material delivery from Supplier XYZ has been received. 10,000 kg of PET pellets added to inventory.',
                    'type' => 'success',
                    'priority' => 'low',
                    'is_read' => true,
                    'data' => ['supplier' => 'Supplier XYZ', 'material' => 'PET pellets', 'quantity' => 10000]
                ],
                [
                    'title' => 'System Maintenance Notice',
                    'message' => 'Scheduled system maintenance will occur tonight from 2:00 AM to 4:00 AM. Some features may be temporarily unavailable.',
                    'type' => 'info',
                    'priority' => 'low',
                    'is_read' => false,
                    'data' => ['maintenance_start' => '2024-06-23 02:00:00', 'maintenance_end' => '2024-06-23 04:00:00']
                ]
            ];
            
            foreach ($notifications as $notificationData) {
                Notification::create([
                    'user_id' => $manufacturer->id,
                    'title' => $notificationData['title'],
                    'message' => $notificationData['message'],
                    'type' => $notificationData['type'],
                    'priority' => $notificationData['priority'],
                    'is_read' => $notificationData['is_read'],
                    'data' => $notificationData['data'],
                    'read_at' => $notificationData['is_read'] ? now()->subHours(rand(1, 24)) : null,
                    'created_at' => now()->subDays(rand(0, 7))->subHours(rand(0, 23))
                ]);
            }
        }
        
        $this->command->info('Sample notifications created successfully for ' . $manufacturers->count() . ' manufacturer(s).');
    }
}
