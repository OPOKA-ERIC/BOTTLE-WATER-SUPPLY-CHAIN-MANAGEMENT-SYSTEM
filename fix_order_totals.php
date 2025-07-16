<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;

echo "Fixing order totals for all existing orders...\n";

// Get all orders
$orders = Order::with('products')->get();
$fixedCount = 0;

foreach ($orders as $order) {
    $oldTotal = $order->total_amount;
    
    // Calculate the correct total
    $order->calculateTotal();
    
    if ($oldTotal != $order->total_amount) {
        echo "Order #{$order->id}: Updated total from UGX {$oldTotal} to UGX {$order->total_amount}\n";
        $fixedCount++;
    }
}

echo "\nFixed {$fixedCount} orders with incorrect totals.\n";
echo "All order totals have been updated successfully!\n"; 