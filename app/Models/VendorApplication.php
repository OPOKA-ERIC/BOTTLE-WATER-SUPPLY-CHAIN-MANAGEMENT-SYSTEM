<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorApplication extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'description',
        'status',
        'rejection_reason',
        // Financial Stability Data
        'annual_revenue',
        'net_worth',
        'years_in_business',
        'credit_rating',
        'has_bankruptcy',
        'has_tax_liens',
        // Reputation Data
        'average_rating',
        'total_reviews',
        'has_legal_issues',
        'legal_issues_description',
        'has_complaints',
        'complaints_description',
        // Regulatory Compliance Data
        'has_business_license',
        'has_tax_registration',
        'has_insurance',
        'insurance_type',
        'has_environmental_compliance',
        'has_safety_certification',
        // Facility Visit Data
        'scheduled_visit_date',
        'visit_status',
        'visit_notes',
        'visit_passed',
        // PDF Document Data
        'pdf_document_path',
        'submitted_at',
        'validated_at',
        // Validation Scores
        'financial_score',
        'reputation_score',
        'compliance_score',
        'overall_score',
        'reviewed_by',
        'reviewed_at'
    ];

    protected $casts = [
        'annual_revenue' => 'decimal:2',
        'net_worth' => 'decimal:2',
        'years_in_business' => 'integer',
        'has_bankruptcy' => 'boolean',
        'has_tax_liens' => 'boolean',
        'average_rating' => 'decimal:1',
        'total_reviews' => 'integer',
        'has_legal_issues' => 'boolean',
        'has_complaints' => 'boolean',
        'has_business_license' => 'boolean',
        'has_tax_registration' => 'boolean',
        'has_insurance' => 'boolean',
        'has_environmental_compliance' => 'boolean',
        'has_safety_certification' => 'boolean',
        'scheduled_visit_date' => 'datetime',
        'visit_passed' => 'boolean',
        'submitted_at' => 'datetime',
        'validated_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'financial_score' => 'decimal:2',
        'reputation_score' => 'decimal:2',
        'compliance_score' => 'decimal:2',
        'overall_score' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes for filtering
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApprovedForVisit($query)
    {
        return $query->where('status', 'approved_for_visit');
    }

    public function scopeConditionalApproval($query)
    {
        return $query->where('status', 'conditional_approval');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeVisitScheduled($query)
    {
        return $query->where('visit_status', 'scheduled');
    }

    public function scopeVisitCompleted($query)
    {
        return $query->where('visit_status', 'completed');
    }

    // Helper methods
    public function isApprovedForVisit()
    {
        return $this->status === 'approved_for_visit';
    }

    public function isConditionallyApproved()
    {
        return $this->status === 'conditional_approval';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function hasVisitScheduled()
    {
        return $this->scheduled_visit_date !== null;
    }

    public function getStatusBadgeClass()
    {
        switch ($this->status) {
            case 'approved_for_visit':
                return 'badge-success';
            case 'conditional_approval':
                return 'badge-warning';
            case 'rejected':
                return 'badge-danger';
            case 'pending':
            default:
                return 'badge-info';
        }
    }

    public function getVisitStatusBadgeClass()
    {
        switch ($this->visit_status) {
            case 'completed':
                return 'badge-success';
            case 'scheduled':
                return 'badge-warning';
            case 'pending':
                return 'badge-info';
            default:
                return 'badge-secondary';
        }
    }
} 