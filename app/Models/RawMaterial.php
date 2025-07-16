<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'name',
        'description',
        'quantity_available',
        'unit_of_measure',
        'price',
        'status',
        'image_path',
    ];

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function purchaseOrders()
    {
        return $this->belongsToMany(PurchaseOrder::class, 'purchase_order_items')
            ->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }
} 