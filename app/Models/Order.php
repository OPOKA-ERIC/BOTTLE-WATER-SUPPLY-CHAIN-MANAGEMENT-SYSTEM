<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'retailer_id',
        'delivery_address',
        'delivery_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
    ];

    public function retailer()
    {
        return $this->belongsTo(User::class, 'retailer_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function deliverySchedule()
    {
        return $this->hasOne(DeliverySchedule::class);
    }

    public function calculateTotal()
    {
        $this->total_amount = $this->products->sum(function ($product) {
            return $product->pivot->quantity * $product->pivot->price;
        });
        $this->save();
    }
} 