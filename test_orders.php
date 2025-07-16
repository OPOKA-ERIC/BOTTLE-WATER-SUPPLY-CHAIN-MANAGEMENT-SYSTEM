<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;

echo "Total orders: " . Order::count() . "\n";
echo "Shipped orders: " . Order::where('status', 'shipped')->count() . "\n";
echo "Orders with delivery schedules: " . Order::whereHas('deliverySchedule')->count() . "\n";

$shippedInTransit = Order::where('status', 'shipped')
    ->whereHas('deliverySchedule', function($q) {
        $q->where('status', 'in_transit');
    })
    ->count();

echo "Shipped and in transit: " . $shippedInTransit . "\n";

if ($shippedInTransit > 0) {
    echo "\nOrders that can be marked as delivered:\n";
    $orders = Order::where('status', 'shipped')
        ->whereHas('deliverySchedule', function($q) {
            $q->where('status', 'in_transit');
        })
        ->with(['deliverySchedule', 'retailer'])
        ->get();
    
    foreach ($orders as $order) {
        echo "Order #{$order->id} - Customer: {$order->retailer->name} - Delivery ID: {$order->deliverySchedule->id}\n";
    }
} 