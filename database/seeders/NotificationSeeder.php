<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Models\PurchaseOrder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get supplier users
        $suppliers = User::where('role', 'supplier')->get();
        
        if ($suppliers->isEmpty()) {
            $this->command->info('No supplier users found. Creating sample notifications skipped.');
            return;
        }

        $supplier = $suppliers->first();

        // Sample notifications for suppliers
        $notifications = [
            [
                'user_id' => $supplier->id,
                'title' => 'New Purchase Order Received',
                'message' => 'Manufacturer ABC has placed a new order for 500 plastic bottles. Please review and confirm the order details.',
                'type' => 'order',
                'priority' => 'high',
                'is_read' => false,
                'data' => ['order_id' => 1]
            ],
            [
                'user_id' => $supplier->id,
                'title' => 'Low Inventory Alert',
                'message' => 'Your plastic bottle inventory is running low (25 units remaining). Consider restocking soon to avoid stockouts.',
                'type' => 'material',
                'priority' => 'medium',
                'is_read' => false,
                'data' => ['material_id' => 1, 'current_quantity' => 25]
            ],
            [
                'user_id' => $supplier->id,
                'title' => 'Order Status Updated',
                'message' => 'Order #PO-2024-001 has been marked as "Processing" by the manufacturer. Prepare materials for production.',
                'type' => 'order',
                'priority' => 'medium',
                'is_read' => true,
                'data' => ['order_id' => 1, 'status' => 'processing']
            ],
            [
                'user_id' => $supplier->id,
                'title' => 'Material Delivery Confirmed',
                'message' => 'Your shipment of 1000 plastic bottles has been delivered and added to inventory. Stock levels updated.',
                'type' => 'material',
                'priority' => 'low',
                'is_read' => true,
                'data' => ['material_id' => 1, 'quantity_added' => 1000]
            ],
            [
                'user_id' => $supplier->id,
                'title' => 'Payment Received',
                'message' => 'Payment of $2,500 has been received for Order #PO-2024-002. Transaction completed successfully.',
                'type' => 'order',
                'priority' => 'medium',
                'is_read' => true,
                'data' => ['order_id' => 2, 'amount' => 2500]
            ],
            [
                'user_id' => $supplier->id,
                'title' => 'System Maintenance Notice',
                'message' => 'Scheduled maintenance will occur tonight from 2 AM to 4 AM. Some features may be temporarily unavailable.',
                'type' => 'system',
                'priority' => 'low',
                'is_read' => false,
                'data' => ['maintenance_time' => '2 AM - 4 AM']
            ],
            [
                'user_id' => $supplier->id,
                'title' => 'Quality Check Required',
                'message' => 'Quality inspection required for batch #QC-2024-001. Please review quality parameters and submit report.',
                'type' => 'material',
                'priority' => 'high',
                'is_read' => false,
                'data' => ['batch_id' => 'QC-2024-001']
            ],
            [
                'user_id' => $supplier->id,
                'title' => 'New Supplier Portal Features',
                'message' => 'New features have been added to the supplier portal including real-time notifications and enhanced reporting.',
                'type' => 'system',
                'priority' => 'low',
                'is_read' => true,
                'data' => ['features' => ['real-time notifications', 'enhanced reporting']]
            ]
        ];

        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }

        $this->command->info('Sample notifications created successfully for supplier: ' . $supplier->name);
    }
}
