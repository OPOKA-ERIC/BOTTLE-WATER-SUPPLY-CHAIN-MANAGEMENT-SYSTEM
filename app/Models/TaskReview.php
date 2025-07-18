<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'supervisor_id',
        'rating',
        'review',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
} 