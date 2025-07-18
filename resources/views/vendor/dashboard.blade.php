@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'BWSCMS'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Welcome, {{ Auth::user()->name }}!</h1>
                        <p class="welcome-subtitle">Manage your vendor applications and track validation progress</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-badge"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-paper"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['total_applications'] }}</h3>
                        <p class="stats-label">Total Applications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-check-2"></i>
                            <span>UpTyped just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-check-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['approved_applications'] }}</h3>
                        <p class="stats-label">Approved for Visit</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-check-2"></i>
                            <span>Ready for facility visit</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-simple-remove"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['rejected_applications'] }}</h3>
                        <p class="stats-label">Rejected</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-check-2"></i>
                            <span>Failed validation criteria</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($application)
        <!-- Application Status -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Your Application Status</h4>
                            <p class="card-subtitle">Track your validation progress</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-badge"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="application-info">
                                    <h5 class="business-name">{{ $application->business_name }}</h5>
                                    <p class="info-item"><strong>Business Type:</strong> {{ $application->business_type }}</p>
                                    <p class="info-item">
                                        <strong>Status:</strong>
                                        <span class="status-badge status-{{ $application->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="application-details">
                                    @if($application->rejection_reason)
                                    <p class="info-item"><strong>Rejection Reason:</strong> 
                                        <span class="rejection-reason">{{ $application->rejection_reason }}</span>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="scores-title">Validation Scores:</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="score-item">
                                            <div class="score-label">Financial</div>
                                            <div class="score-value">{{ $application->financial_score == 1 ? 1 : 0 }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="score-item">
                                            <div class="score-label">Reputation</div>
                                            <div class="score-value">{{ $application->reputation_score == 1 ? 1 : 0 }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="score-item">
                                            <div class="score-label">Compliance</div>
                                            <div class="score-value">{{ $application->compliance_score == 1 ? 1 : 0 }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="score-item">
                                            <div class="score-label">Overall</div>
                                            <div class="score-value">{{ $application->overall_score !== null ? $application->overall_score : 0 }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- No Application -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">No Application Found</h4>
                            <p class="card-subtitle">Start your vendor validation process</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-simple-add"></i>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="no-application-content">
                            <i class="nc-icon nc-paper" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                            <p class="no-application-text">You haven't submitted a vendor application yet.</p>
                            <a href="{{ route('vendor.applications.create') }}" class="submit-btn">
                                <i class="nc-icon nc-simple-add"></i>
                                <span>Submit Application</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Applications -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Applications</h4>
                            <p class="card-subtitle">Track all your submitted applications</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-badge"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Business Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Financial</th>
                                        <th>Reputation</th>
                                        <th>Compliance</th>
                                        <th>Overall</th>
                                        <th>Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentApplications as $app)
                                    <tr>
                                        <td><span class="business-name">{{ $app->business_name }}</span></td>
                                        <td>{{ $app->business_type }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $app->status === 'approved' ? 'approved' : 'rejected' }}">
                                                @if($app->status === 'approved')
                                                    Approved
                                                @else
                                                    Rejected
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $app->financial_score == 1 ? 1 : 0 }}</td>
                                        <td>{{ $app->reputation_score == 1 ? 1 : 0 }}</td>
                                        <td>{{ $app->compliance_score == 1 ? 1 : 0 }}</td>
                                        <td>{{ $app->overall_score !== null ? $app->overall_score : 0 }}</td>
                                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('vendor.applications.show', $app->id) }}" class="action-btn">
                                                <i class="nc-icon nc-zoom-split-in"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No applications found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Content spacing to account for fixed navbar */
.content {
    padding-top: 100px !important;
    margin-top: 0;
}

/* Welcome Section */
.welcome-card {
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
}

.welcome-content {
    flex: 1;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.welcome-subtitle {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.9;
    font-weight: 400;
}

.welcome-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 30px;
}

.welcome-icon i {
    font-size: 40px;
    color: white;
}

/* Statistics Cards */
.stats-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 30px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stats-icon i {
    font-size: 28px;
    color: white;
}

.stats-content {
    flex: 1;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 5px 0;
    line-height: 1.2;
}

.stats-label {
    font-size: 1rem;
    color: #666;
    margin: 0 0 10px 0;
    font-weight: 500;
}

.stats-footer {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #888;
}

.stats-footer i {
    font-size: 14px;
}

/* Content Cards */
.content-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: 100%;
}

.card-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
}

.header-content {
    flex: 1;
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

/* Application Info */
.application-info, .application-details {
    padding: 20px;
    background: rgba(25, 118, 210, 0.05);
    border-radius: 15px;
    border: 1px solid rgba(25, 118, 210, 0.1);
}

.business-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1976d2;
    margin: 0 0 15px 0;
}

.info-item {
    margin: 10px 0;
    font-size: 1rem;
    color: #333;
}

.score-highlight {
    color: #2e7d32;
    font-weight: 700;
    font-size: 1.1rem;
}

.Type-highlight {
    color: #1976d2;
    font-weight: 600;
}

.rejection-reason {
    color: #d32f2f;
    font-style: italic;
}

/* Status Badges */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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

.status-under_review {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

.status-visit_scheduled {
    background: rgba(156, 39, 176, 0.1);
    color: #9c27b0;
}

.status-visit_completed {
    background: rgba(0, 150, 136, 0.1);
    color: #009688;
}

/* Progress Bars */
.scores-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

.score-item {
    margin-bottom: 20px;
}

.score-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #666;
    margin-bottom: 8px;
}

.progress-custom {
    height: 25px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    overflow: hidden;
    position: relative;
}

.progress-bar-custom {
    height: 100%;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    transition: width 0.3s ease;
}

/* No Application */
.no-application-content {
    padding: 40px 20px;
}

.no-application-text {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 30px;
}

.submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.submit-btn i {
    font-size: 18px;
}

/* Table Styling */
.table {
    margin: 0;
}

.table thead th {
    background: rgba(25, 118, 210, 0.1);
    color: #333;
    font-weight: 600;
    border: none;
    padding: 15px;
    font-size: 0.9rem;
}

.table tbody td {
    padding: 15px;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.table tbody tr:hover {
    background: rgba(25, 118, 210, 0.05);
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.action-btn i {
    font-size: 14px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        padding-top: 120px !important;
    }

    .welcome-card {
        flex-direction: column;
        text-align: center;
        padding: 30px 20px;
    }

    .welcome-title {
        font-size: 2rem;
    }

    .welcome-icon {
        margin: 20px 0 0 0;
    }

    .stats-card {
        padding: 20px;
    }

    .stats-number {
        font-size: 1.5rem;
    }

    .card-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .header-icon {
        margin: 0;
    }

    .application-info, .application-details {
        margin-bottom: 20px;
    }
}
</style>
@endsection 
