<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssignmentAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'old_assigned_to',
        'new_assigned_to',
        'changed_by',
        'reason',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function oldAssignee()
    {
        return $this->belongsTo(User::class, 'old_assigned_to');
    }

    public function newAssignee()
    {
        return $this->belongsTo(User::class, 'new_assigned_to');
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
} 