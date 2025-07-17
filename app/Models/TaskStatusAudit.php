<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatusAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'old_status',
        'new_status',
        'changed_by',
        'reason',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
} 