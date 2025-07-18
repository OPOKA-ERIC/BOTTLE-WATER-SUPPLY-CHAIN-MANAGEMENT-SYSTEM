@extends('layouts.app', ['activePage' => 'reports', 'title' => 'Vendor Reports'])

@section('content')
<!-- DEBUG: Vendor Reports View Loaded -->
<div class="content" style="margin-top: 40px !important;">
    <div class="container-fluid vendor-bg">
        <!-- Applications Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header" style="background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%); color: white; padding: 25px 30px; display: flex; align-items: center; justify-content: space-between; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <div class="header-content">
                            <h4 class="card-title" style="color: white; font-size: 1.5rem; font-weight: 700; margin: 0 0 5px 0; line-height: 1.2;">Vendor Activity Report</h4>
                            <p class="card-subtitle" style="color: white; font-size: 0.95rem; margin: 0; opacity: 0.9; font-weight: 400;">Summary of your application history</p>
                        </div>
                        <div class="header-icon" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-left: 20px;">
                            <i class="nc-icon nc-badge" style="font-size: 24px; color: white;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Date:</strong> {{ now()->format('Y-m-d H:i') }}</p>

                        <h5 class="mt-4">Applications</h5>
                        @if($applications->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Status</th>
                                        <th>Submitted</th>
                                        <th>Scores (F/R/C/O)</th>
                                        <th>Rejection Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($applications as $app)
                                    <tr>
                                        <td>{{ $app->id }}</td>
                                        <td>{{ $app->business_name }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $app->status }}">
                                                {{ ucfirst($app->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $app->submitted_at ? $app->submitted_at->format('Y-m-d') : '-' }}</td>
                                        <td>{{ (int) $app->financial_score }}/{{ (int) $app->reputation_score }}/{{ (int) $app->compliance_score }}/{{ (int) $app->overall_score }}</td>
                                        <td>@if($app->status === 'rejected'){{ $app->rejection_reason ?? '-' }}@else - @endif</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="alert alert-info mt-4">
                                You have no approved or rejected vendor applications yet. Once your application is reviewed, it will appear here.
                            </div>
                        @endif
                        <!-- Download Button at the Bottom -->
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('vendor.reports.download') }}" class="btn btn-primary" target="_blank" rel="noopener">
                                <i class="nc-icon nc-single-copy-04"></i> Download PDF Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body, .vendor-bg {
    background: #f4f6fa !important;
}
.stats-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
    padding: 1.5rem 1.2rem;
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    min-height: 120px;
}
.stats-icon {
    width: 48px;
    height: 48px;
    background: #e3e6f3;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: #1a237e;
}
.stats-content {
    flex: 1;
}
.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1a237e;
    margin-bottom: 0.2rem;
}
.stats-label {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 0;
}
.status-badge {
    display: inline-block;
    padding: 0.25em 0.7em;
    border-radius: 8px;
    font-size: 0.95em;
    font-weight: 600;
    color: #fff;
}
.status-approved {
    background: #28a745;
}
.status-rejected {
    background: #dc3545;
}
.status-pending {
    background: #ffc107;
    color: #222;
}
.content-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
    margin-bottom: 2rem;
}
.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.2rem 1.5rem 1rem 1.5rem;
    border-bottom: 1px solid #e3e6f3;
    background: #f8f9fa;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.header-content {
    flex: 1;
}
.card-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1a237e;
    margin-bottom: 0.2rem;
}
.card-subtitle {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 0;
}
.header-icon {
    width: 48px;
    height: 48px;
    background: #e3e6f3;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #1a237e;
}
.report-header-blue {
    background: #1a237e !important;
    color: #fff !important;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    padding: 1.2rem 1.5rem 1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.report-header-blue .card-title,
.report-header-blue .card-subtitle,
.report-header-blue .header-icon i {
    color: #fff !important;
}
</style>
@endsection 