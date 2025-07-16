<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Updating order prices to match new product prices...\n";

// Get all order_product records
$orderProducts = DB::table('order_product')->get();

foreach ($orderProducts as $orderProduct) {
    // Get the product price
    $product = DB::table('products')->where('id', $orderProduct->product_id)->first();
    
    if ($product) {
        // Update the order_product price to match the current product price
        DB::table('order_product')
            ->where('order_id', $orderProduct->order_id)
            ->where('product_id', $orderProduct->product_id)
            ->update(['price' => $product->price]);
            
        echo "Updated order {$orderProduct->order_id}, product {$product->name} to UGX {$product->price}\n";
    }
}

echo "Order prices updated successfully!\n"; 