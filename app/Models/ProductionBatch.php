<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionBatch extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'product_id',
        'quantity',
        'production_date',
        'start_date',
        'estimated_completion',
        'status',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'production_date' => 'date',
        'start_date' => 'date',
        'estimated_completion' => 'date',
        'completed_at' => 'datetime',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
} 