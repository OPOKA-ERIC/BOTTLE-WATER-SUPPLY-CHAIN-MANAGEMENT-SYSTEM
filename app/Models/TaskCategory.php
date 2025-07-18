<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'assigned_roles',
        'priority',
        'estimated_duration_hours',
        'is_active',
        'color',
        'icon',
    ];

    protected $casts = [
        'assigned_roles' => 'array',
        'is_active' => 'boolean',
        'estimated_duration_hours' => 'integer',
    ];

    // Relationships
    public function tasks()
    {
        return $this->hasMany(Task::class, 'category', 'name');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    // Methods
    public function getEligibleUsers()
    {
        return User::whereIn('role', $this->assigned_roles)
            ->where('is_available', true)
            ->where('status', 'active')
            ->get();
    }

    public function getBestAssignee()
    {
        $eligibleUsers = $this->getEligibleUsers();
        
        if ($eligibleUsers->isEmpty()) {
            return null;
        }

        // Find user with least workload
        $bestUser = $eligibleUsers->sortBy(function ($user) {
            return $user->getActiveTasksCount();
        })->first();

        return $bestUser;
    }

    public function getColorClass()
    {
        return match($this->color) {
            'primary' => 'bg-primary',
            'secondary' => 'bg-secondary',
            'success' => 'bg-success',
            'danger' => 'bg-danger',
            'warning' => 'bg-warning',
            'info' => 'bg-info',
            'light' => 'bg-light',
            'dark' => 'bg-dark',
            default => 'bg-primary'
        };
    }

    public function getIconClass()
    {
        return $this->icon ?? 'nc-icon nc-briefcase-24';
    }

    public function getRoleBadges()
    {
        return collect($this->assigned_roles)->map(function ($role) {
            return '<span class="badge badge-info me-1">' . ucfirst($role) . '</span>';
        })->implode('');
    }
} 