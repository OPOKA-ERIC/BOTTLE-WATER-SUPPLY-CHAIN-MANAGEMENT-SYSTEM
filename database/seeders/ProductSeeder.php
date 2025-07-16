<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Mineral Water 500ml',
            'description' => 'Pure mineral water in 500ml bottle',
            'price' => 500,
            'status' => 'active'
        ]);

        Product::create([
            'name' => 'Mineral Water 1L',
            'description' => 'Pure mineral water in 1L bottle',
            'price' => 1000,
            'status' => 'active'
        ]);

        Product::create([
            'name' => 'Mineral Water 5L',
            'description' => 'Pure mineral water in 5L bottle',
            'price' => 5000,
            'status' => 'active'
        ]);
    }
} 