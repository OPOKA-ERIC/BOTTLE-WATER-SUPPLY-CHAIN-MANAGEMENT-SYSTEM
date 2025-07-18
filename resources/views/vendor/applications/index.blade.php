@extends('layouts.app', ['activePage' => 'applications', 'title' => 'Vendor Applications'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header-card">
                    <div class="header-content">
                        <h1 class="page-title">Vendor Applications</h1>
                        <p class="page-subtitle">Manage and track your vendor applications</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('vendor.applications.create') }}" class="create-order-btn">
                            <i class="nc-icon nc-simple-add"></i>
                            <span>Submit New Application</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Applications Table -->
        <div class="row">
            <div class="col-12">
                <div class="orders-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Applications List</h4>
                            <p class="card-subtitle">All your submitted vendor applications</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-paper"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($applications->count())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
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
                                    @foreach($applications as $application)
                                    <tr>
                                        <td><span class="order-id">#{{ $application->id }}</span></td>
                                        <td>{{ $application->business_name ?? 'N/A' }}</td>
                                        <td>{{ $application->business_type ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($application->status === 'approved' ? 'approved' : 'rejected') }}">
                                                @if($application->status === 'approved')
                                                    Approved
                                                @else
                                                    Rejected
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $application->financial_score == 1 ? 1 : 0 }}</td>
                                        <td>{{ $application->reputation_score == 1 ? 1 : 0 }}</td>
                                        <td>{{ $application->compliance_score == 1 ? 1 : 0 }}</td>
                                        <td>{{ $application->overall_score !== null ? $application->overall_score : '❓' }}</td>
                                        <td>{{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('vendor.applications.show', $application->id) }}" class="action-btn">
                                                <i class="nc-icon nc-zoom-split-in"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-container">
                            {{ $applications->links() }}
                        </div>
                        @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="nc-icon nc-paper"></i>
                            </div>
                            <h3 class="empty-title">No Applications Found</h3>
                            <p class="empty-subtitle">You haven't submitted any applications yet. Start by submitting your first application!</p>
                            <a href="{{ route('vendor.applications.create') }}" class="create-order-btn">
                                <i class="nc-icon nc-simple-add"></i>
                                <span>Submit New Application</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Content spacing to account for fixed navbar - increased padding with higher specificity */
body .content,
.wrapper .content,
.main-panel .content {
    padding-top: 140px !important;
    margin-top: 0 !important;
    min-height: calc(100vh - 140px) !important;
}

/* Ensure proper spacing for the main container */
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

.header-actions {
    display: flex;
    align-items: center;
}

.create-order-btn {
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
    cursor: pointer;
}

.create-order-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
}

.create-order-btn i {
    font-size: 18px;
}

/* Orders Card (used for applications) */
.orders-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-height: 400px;
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

.order-id {
    font-weight: 600;
    color: #1976d2;
    font-size: 1.1rem;
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

.status-processing {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
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

/* Pagination */
.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    border: none;
    color: #1976d2;
    padding: 10px 15px;
    margin: 0 2px;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    font-weight: 500;
}

.pagination .page-link:hover {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(25, 118, 210, 0.2);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

/* Smaller and nicer pagination arrows */
.pagination .page-link[aria-label="Previous"],
.pagination .page-link[aria-label="Next"] {
    padding: 8px 12px !important;
    font-size: 0.75rem !important;
    min-width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(25, 118, 210, 0.05);
    border: 1px solid rgba(25, 118, 210, 0.1);
}

.pagination .page-link[aria-label="Previous"]:hover,
.pagination .page-link[aria-label="Next"]:hover {
    background: rgba(25, 118, 210, 0.15);
    border-color: rgba(25, 118, 210, 0.3);
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(25, 118, 210, 0.25);
}

.pagination .page-link[aria-label="Previous"]:before {
    content: "‹";
    font-size: 1.2rem;
    font-weight: bold;
    line-height: 1;
}

.pagination .page-link[aria-label="Next"]:before {
    content: "›";
    font-size: 1.2rem;
    font-weight: bold;
    line-height: 1;
}

/* Disabled pagination arrows */
.pagination .page-item.disabled .page-link {
    background: rgba(108, 117, 125, 0.05);
    color: rgba(108, 117, 125, 0.5);
    border-color: rgba(108, 117, 125, 0.1);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.pagination .page-item.disabled .page-link:hover {
    background: rgba(108, 117, 125, 0.05);
    color: rgba(108, 117, 125, 0.5);
    border-color: rgba(108, 117, 125, 0.1);
    transform: none;
    box-shadow: none;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 30px;
    color: #666;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.1), rgba(13, 71, 161, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
}

.empty-icon i {
    font-size: 40px;
    color: #1976d2;
}

.empty-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 15px 0;
}

.empty-subtitle {
    font-size: 1.1rem;
    color: #666;
    margin: 0 0 30px 0;
    line-height: 1.5;
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
    
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .table thead th,
    .table tbody td {
        padding: 10px 8px;
    }
}

/* Additional spacing for smaller screens */
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
        padding: 20px;
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