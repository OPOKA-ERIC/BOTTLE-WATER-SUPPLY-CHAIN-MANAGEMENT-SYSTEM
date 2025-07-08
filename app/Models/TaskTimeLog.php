<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TaskTimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'description',
        'activity_type',
        'is_billable',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_billable' => 'boolean',
    ];

    // Relationships
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeBillable($query)
    {
        return $query->where('is_billable', true);
    }

    public function scopeNonBillable($query)
    {
        return $query->where('is_billable', false);
    }

    public function scopeByActivityType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('start_time', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // Methods
    public function stopTimer()
    {
        $this->update([
            'end_time' => now(),
            'duration_minutes' => $this->start_time->diffInMinutes(now())
        ]);
    }

    public function getFormattedDurationAttribute()
    {
        $minutes = $this->duration_minutes ?? 0;
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$remainingMinutes}m";
        }
        return "{$remainingMinutes}m";
    }

    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time->format('M d, Y g:i A');
    }

    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? $this->end_time->format('M d, Y g:i A') : 'Running';
    }

    public function isRunning()
    {
        return $this->start_time && !$this->end_time;
    }

    public function getCurrentDuration()
    {
        if (!$this->start_time) return 0;
        
        $endTime = $this->end_time ?? now();
        return $this->start_time->diffInMinutes($endTime);
    }
}
