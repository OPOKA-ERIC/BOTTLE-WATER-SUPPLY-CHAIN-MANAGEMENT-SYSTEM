<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price')->withTimestamps();
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    // Placeholder for customerSegments relationship
    public function customerSegments()
    {
        return $this->belongsToMany(CustomerSegment::class);
    }
} 