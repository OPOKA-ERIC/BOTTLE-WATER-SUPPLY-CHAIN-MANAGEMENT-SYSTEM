<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'priority',
        'is_read',
        'data',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null
        ]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function getTypeIconAttribute()
    {
        return [
            'info' => 'nc-icon nc-chart-bar-32',
            'success' => 'nc-icon nc-check-2',
            'warning' => 'nc-icon nc-alert-circle-i',
            'error' => 'nc-icon nc-simple-remove'
        ][$this->type] ?? 'nc-icon nc-bell-55';
    }

    public function getPriorityColorAttribute()
    {
        return [
            'low' => '#27ae60',
            'medium' => '#f39c12',
            'high' => '#e74c3c'
        ][$this->priority] ?? '#95a5a6';
    }
}
