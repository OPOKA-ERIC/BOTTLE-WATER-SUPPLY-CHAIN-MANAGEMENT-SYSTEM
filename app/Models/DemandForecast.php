<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandForecast extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'product_id',
        'forecast_date',
        'predicted_quantity',
        'confidence_level',
        'factors',
        'notes',
    ];

    protected $casts = [
        'forecast_date' => 'datetime',
        'factors' => 'array',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFactorsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setFactorsAttribute($value)
    {
        $this->attributes['factors'] = json_encode($value);
    }
} 