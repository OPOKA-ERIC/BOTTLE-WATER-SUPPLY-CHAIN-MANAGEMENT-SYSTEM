<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate_number',
        'model',
        'type',
        'status',
    ];

    public function deliverySchedules()
    {
        return $this->hasMany(DeliverySchedule::class);
    }
} 