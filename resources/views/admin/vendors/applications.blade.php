@extends('layouts.app', ['activePage' => 'vendor-applications', 'title' => 'Vendor Applications'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Vendor Applications</h1>
                        <p class="welcome-subtitle">Review, approve, or reject vendor applications</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-paper"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">All Vendor Applications</h4>
                            <p class="card-subtitle">Manage and review all vendor applications</p>
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
                            <th>Applicant</th>
                            <th>Status</th>
                            <th>Financial</th>
                            <th>Reputation</th>
                            <th>Compliance</th>
                            <th>Overall</th>
                            <th>Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            @if($application->status === 'approved' || $application->status === 'rejected')
                            <tr>
                                <td><span class="order-id">#{{ $application->id }}</span></td>
                                <td>{{ $application->business_name ?? 'N/A' }}</td>
                                <td>{{ $application->user->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-badge status-{{ $application->status }}">
                                        {{ $application->status === 'approved' ? 'Approved' : 'Rejected' }}
                                    </span>
                                </td>
                                <td>{{ $application->financial_score !== null ? (int)$application->financial_score : '-' }}</td>
                                <td>{{ $application->reputation_score !== null ? (int)$application->reputation_score : '-' }}</td>
                                <td>{{ $application->compliance_score !== null ? (int)$application->compliance_score : '-' }}</td>
                                <td>{{ $application->overall_score !== null ? (int)$application->overall_score : '-' }}</td>
                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                        </div>
                        <!-- Pagination -->
                @if($applications->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Vendor applications pagination">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if ($applications->onFirstPage())
                                    <li class="page-item disabled">
                                            <span class="page-link">‹</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $applications->previousPageUrl() }}">‹</a>
                                        </li>
                                    @endif
                                    {{-- Pagination Elements --}}
                                    @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
                                        @if ($page == $applications->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach
                                {{-- Next Page Link --}}
                                @if ($applications->hasMorePages())
                                    <li class="page-item">
                                            <a class="page-link" href="{{ $applications->nextPageUrl() }}">›</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                            <span class="page-link">›</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            @else
                        <p class="text-center">No vendor applications found.</p>
            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.content {
    padding-top: 100px !important;
    margin-top: 0;
}
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
.welcome-content { flex: 1; }
.welcome-title { font-size: 2.5rem; font-weight: 700; margin: 0 0 10px 0; line-height: 1.2; }
.welcome-subtitle { font-size: 1.1rem; margin: 0; opacity: 0.9; font-weight: 400; }
.welcome-icon { width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-left: 30px; }
.welcome-icon i { font-size: 40px; color: white; }
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
.header-content { flex: 1; }
.card-title { font-size: 1.5rem; font-weight: 700; margin: 0 0 5px 0; line-height: 1.2; }
.card-subtitle { font-size: 0.95rem; margin: 0; opacity: 0.9; font-weight: 400; }
.header-icon { width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-left: 20px; }
.header-icon i { font-size: 24px; color: white; }
.card-body { padding: 30px; }
.table { margin: 0; }
.table thead th { background: rgba(25, 118, 210, 0.1); color: #333; font-weight: 600; border: none; padding: 15px; font-size: 0.9rem; }
.table tbody td { padding: 15px; border: none; border-bottom: 1px solid rgba(0, 0, 0, 0.05); vertical-align: middle; }
.table tbody tr:hover { background: rgba(25, 118, 210, 0.05); }
.order-id { font-weight: 600; color: #1976d2; }
.status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.status-approved { background: rgba(46, 125, 50, 0.1); color: #2e7d32; }
.status-pending { background: rgba(237, 108, 2, 0.1); color: #ed6c02; }
.status-rejected { background: rgba(211, 47, 47, 0.1); color: #d32f2f; }
.action-btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; text-decoration: none; border-radius: 8px; font-size: 0.85rem; font-weight: 500; transition: all 0.3s ease; }
.action-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); color: white; text-decoration: none; }
.action-btn i { font-size: 14px; }
@media (max-width: 768px) {
    .content { padding-top: 120px !important; }
    .welcome-card { flex-direction: column; text-align: center; padding: 30px 20px; }
    .welcome-title { font-size: 2rem; }
    .welcome-icon { margin: 20px 0 0 0; }
    .card-header { flex-direction: column; text-align: center; gap: 15px; }
    .header-icon { margin: 0; }
}
</style>
@endsection 