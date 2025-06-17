<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSegment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'criteria',
        'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function customers()
    {
        return $this->hasMany(User::class, 'customer_segment_id');
    }
}
