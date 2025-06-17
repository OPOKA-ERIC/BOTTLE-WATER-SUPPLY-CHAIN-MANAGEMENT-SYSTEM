<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;

class InventorySeeder extends Seeder
{
    public function run()
    {
        // Get the first manufacturer user
        $manufacturer = User::where('role', 'manufacturer')->first();
        
        if ($manufacturer) {
            // Get all products
            $products = Product::all();
            
            foreach ($products as $product) {
                Inventory::create([
                    'manufacturer_id' => $manufacturer->id,
                    'product_id' => $product->id,
                    'quantity' => rand(100, 1000),
                    'expiry_date' => now()->addMonths(6),
                    'status' => 'available'
                ]);
            }
        }
    }
} 