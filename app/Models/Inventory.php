<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'product_id',
        'quantity',
        'expiry_date',
        'status',
        'location',
        'batch_number',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
} 