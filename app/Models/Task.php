<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Notifications\TaskStatusNotification;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'assigned_by',
        'assigned_to',
        'priority',
        'status',
        'category',
        'due_date',
        'start_date',
        'completed_at',
        'estimated_hours',
        'actual_hours',
        'progress_percentage',
        'notes',
        'attachments',
        'dependencies',
        'location',
        'visibility',
        'is_recurring',
        'recurrence_pattern',
        'created_by',
        // New fields for assignment audit
        'assignment_method',
        'assignment_reason',
        'contact',
        'is_read',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'start_date' => 'datetime',
        'completed_at' => 'datetime',
        'attachments' => 'array',
        'dependencies' => 'array',
        'is_recurring' => 'boolean',
    ];

    // Relationships
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function timeLogs()
    {
        return $this->hasMany(TaskTimeLog::class);
    }

    public function assignmentAudits()
    {
        return $this->hasMany(TaskAssignmentAudit::class);
    }

    public function statusAudits()
    {
        return $this->hasMany(TaskStatusAudit::class);
    }

    // Scopes for filtering
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', today())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [now(), now()->endOfWeek()])
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByAssignee($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeByCreator($query, $userId)
    {
        return $query->where('assigned_by', $userId);
    }

    // Accessors
    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && !in_array($this->status, ['completed', 'cancelled']);
    }

    public function getDaysUntilDueAttribute()
    {
        if (!$this->due_date) return null;
        return now()->diffInDays($this->due_date, false);
    }

    public function getTotalTimeSpentAttribute()
    {
        return $this->timeLogs()->sum('duration_minutes');
    }

    public function getFormattedTotalTimeAttribute()
    {
        $minutes = $this->total_time_spent;
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return "{$hours}h {$remainingMinutes}m";
    }

    // Methods
    public function startTask()
    {
        $this->update([
            'status' => 'in_progress',
            'start_date' => now()
        ]);
    }

    public function completeTask()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100
        ]);
        // Notify assignee
        if ($this->assignedTo) {
            $this->assignedTo->notify(new TaskStatusNotification('Task "' . $this->title . '" has been completed.', $this->id));
        }
    }

    public function updateProgress($percentage)
    {
        $this->update(['progress_percentage' => min(100, max(0, $percentage))]);
        
        if ($percentage >= 100) {
            $this->completeTask();
        }
    }

    public function assignTo($userId)
    {
        $this->update(['assigned_to' => $userId]);
    }

    public function isAssignedTo($userId)
    {
        return $this->assigned_to == $userId;
    }

    public function canBeStarted()
    {
        return $this->status === 'pending' && $this->assigned_to;
    }

    public function canBeCompleted()
    {
        return $this->status === 'in_progress';
    }

    public function getPriorityColor()
    {
        return match($this->priority) {
            'urgent' => 'danger',
            'high' => 'warning',
            'medium' => 'info',
            'low' => 'success',
            default => 'secondary'
        };
    }

    public function getStatusColor()
    {
        return match($this->status) {
            'completed' => 'success',
            'in_progress' => 'info',
            'on_hold' => 'warning',
            'cancelled' => 'danger',
            'pending' => 'secondary',
            default => 'secondary'
        };
    }

    public function getCategoryIcon()
    {
        return match($this->category) {
            'production' => 'nc-icon nc-settings-gear-65',
            'inventory' => 'nc-icon nc-box-2',
            'quality_control' => 'nc-icon nc-check-2',
            'delivery' => 'nc-icon nc-delivery-fast',
            'maintenance' => 'nc-icon nc-settings-gear-64',
            'admin' => 'nc-icon nc-single-02',
            'customer_service' => 'nc-icon nc-support-17',
            default => 'nc-icon nc-briefcase-24'
        };
    }

    public function checkAndNotifyOverdue()
    {
        if ($this->is_overdue && $this->assignedTo) {
            $this->assignedTo->notify(new TaskStatusNotification('Task "' . $this->title . '" is overdue.', $this->id));
        }
    }

    // Mark task as read/acknowledged
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
