@extends('layouts.app', ['activePage' => 'applications', 'title' => 'Application Details'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header-card">
                    <div class="header-content">
                        <h1 class="page-title">Application Details</h1>
                        <p class="page-subtitle">View your vendor application information and status</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('vendor.applications.index') }}" class="back-btn">
                            <i class="nc-icon nc-minimal-left"></i>
                            <span>Back to Applications</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Details -->
        <div class="row">
            <div class="col-lg-8">
                <div class="application-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Application Information</h4>
                            <p class="card-subtitle">Business and application details</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-paper"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="application-details">
                            <div class="detail-row">
                                <div class="detail-label">Application ID</div>
                                <div class="detail-value">#{{ $application->id }}</div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="status-badge status-{{ strtolower($application->status ?? 'pending') }}">
                                        {{ ucfirst($application->status ?? 'N/A') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Vendor Name</div>
                                <div class="detail-value">{{ $application->user->name ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Business Name</div>
                                <div class="detail-value">{{ $application->business_name ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Business Type</div>
                                <div class="detail-value">{{ $application->business_type ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Business Description</div>
                                <div class="detail-value description-text">{{ $application->description ?? 'No description provided' }}</div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Submitted Date</div>
                                <div class="detail-value">{{ $application->created_at ? $application->created_at->format('F d, Y \a\t g:i A') : 'N/A' }}</div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">Last Updated</div>
                                <div class="detail-value">{{ $application->updated_at ? $application->updated_at->format('F d, Y \a\t g:i A') : 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="status-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Application Status</h4>
                            <p class="card-subtitle">Current processing status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="status-info">
                            <div class="status-indicator">
                                <span class="status-badge status-{{ strtolower($application->status ?? 'pending') }}">
                                    {{ ucfirst($application->status ?? 'N/A') }}
                                </span>
                            </div>
                            <div class="status-description">
                                @if($application->status == 'pending')
                                    <p>Your application is currently under review by our team.</p>
                                @elseif($application->status == 'approved')
                                    <p>Congratulations! Your application has been approved.</p>
                                @elseif($application->status == 'rejected')
                                    <p>Your application has been reviewed but not approved.</p>
                                @elseif($application->status == 'processing')
                                    <p>Your application is being processed by our team.</p>
                                @else
                                    <p>Application status is being determined.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="actions-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Actions</h4>
                            <p class="card-subtitle">Available options</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-64"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ route('vendor.applications.index') }}" class="action-btn secondary">
                                <i class="nc-icon nc-minimal-left"></i>
                                <span>Back to List</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Content spacing to account for fixed navbar */
body .content,
.wrapper .content,
.main-panel .content {
    padding-top: 140px !important;
    margin-top: 0 !important;
    min-height: calc(100vh - 140px) !important;
}

.container-fluid {
    padding: 0 30px !important;
    max-width: 1400px !important;
    margin: 0 auto !important;
}

/* Page Header */
.page-header-card {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    border-radius: 20px;
    padding: 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 30px;
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.9;
    font-weight: 400;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
}

/* Cards */
.application-card,
.status-card,
.actions-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 30px;
}

.card-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 5px 0;
    line-height: 1.2;
}

.card-subtitle {
    font-size: 0.95rem;
    margin: 0;
    opacity: 0.9;
    font-weight: 400;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 20px;
}

.header-icon i {
    font-size: 24px;
    color: white;
}

.card-body {
    padding: 30px;
}

/* Application Details */
.application-details {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.detail-row {
    display: flex;
    align-items: flex-start;
    padding: 15px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #333;
    min-width: 150px;
    flex-shrink: 0;
    font-size: 0.95rem;
}

.detail-value {
    flex: 1;
    color: #666;
    font-size: 1rem;
}

.description-text {
    line-height: 1.6;
    white-space: pre-wrap;
}

/* Status Badges */
.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.status-pending {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-approved {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-rejected {
    background: rgba(211, 47, 47, 0.1);
    color: #d32f2f;
}

.status-processing {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

/* Status Card */
.status-info {
    text-align: center;
    padding: 20px 0;
}

.status-indicator {
    margin-bottom: 20px;
}

.status-description p {
    color: #666;
    line-height: 1.6;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    width: 100%;
}

.action-btn.secondary {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    border: 1px solid rgba(108, 117, 125, 0.3);
}

.action-btn.secondary:hover {
    background: rgba(108, 117, 125, 0.2);
    color: #6c757d;
    transform: translateY(-2px);
    text-decoration: none;
}

.action-btn i {
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    body .content,
    .wrapper .content,
    .main-panel .content {
        padding-top: 160px !important;
    }
    
    .container-fluid {
        padding: 0 15px !important;
    }
    
    .page-header-card {
        flex-direction: column;
        text-align: center;
        gap: 20px;
        padding: 30px 20px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .header-icon {
        margin: 0;
    }
    
    .detail-row {
        flex-direction: column;
        gap: 8px;
    }
    
    .detail-label {
        min-width: auto;
    }
    
    .card-body {
        padding: 20px;
    }
}

@media (max-width: 576px) {
    body .content,
    .wrapper .content,
    .main-panel .content {
        padding-top: 180px !important;
    }
    
    .page-header-card {
        padding: 25px 15px;
    }
    
    .card-body {
        padding: 15px;
    }
}

/* Force override any conflicting styles */
.content {
    padding-top: 140px !important;
    margin-top: 0 !important;
}

@media (max-width: 768px) {
    .content {
        padding-top: 160px !important;
    }
}

@media (max-width: 576px) {
    .content {
        padding-top: 180px !important;
    }
}
</style>
@endsection 