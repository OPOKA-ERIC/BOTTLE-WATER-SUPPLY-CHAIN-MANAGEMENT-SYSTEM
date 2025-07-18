@extends('layouts.app', ['activePage' => 'admin-reports', 'title' => 'Admin Reports'])

@section('content')
<div class="content" style="margin-top: 40px !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header" style="background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%); color: white; padding: 25px 30px; display: flex; align-items: center; justify-content: space-between; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <div class="header-content">
                            <h4 class="card-title" style="color: white; font-size: 1.5rem; font-weight: 700; margin: 0 0 5px 0; line-height: 1.2;">Admin Activity Report</h4>
                            <p class="card-subtitle" style="color: white; font-size: 0.95rem; margin: 0; opacity: 0.9; font-weight: 400;">Summary of your activities and system statistics</p>
                        </div>
                        <div class="header-icon" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-left: 20px;">
                            <i class="nc-icon nc-single-copy-04" style="font-size: 24px; color: white;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Date:</strong> {{ now()->format('Y-m-d H:i') }}</p>

                        <h5 class="mt-4">System Statistics</h5>
                        <ul>
                            <li><strong>Total Users:</strong> {{ $stats['total_users'] }}</li>
                            <li><strong>Total Orders:</strong> {{ $stats['total_orders'] }}</li>
                            <li><strong>Total Inventory:</strong> {{ $stats['total_inventory'] }}</li>
                            <li><strong>Total Vendor Applications:</strong> {{ $stats['total_vendor_applications'] }}</li>
                            <li><strong>Total Tasks:</strong> {{ $stats['total_tasks'] }}</li>
                            <li><strong>Completed Tasks:</strong> {{ $stats['completed_tasks'] }}</li>
                            <li><strong>Pending Tasks:</strong> {{ $stats['pending_tasks'] }}</li>
                            <li><strong>In Progress Tasks:</strong> {{ $stats['in_progress_tasks'] }}</li>
                        </ul>

                        <h5 class="mt-4">Recent Activities</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>Recent Orders</h6>
                                <ul>
                                    @foreach($recentActivities['orders'] as $order)
                                        <li>Order #{{ $order->id }} - {{ $order->status }} ({{ $order->created_at->format('Y-m-d') }})</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6>Recent Vendor Applications</h6>
                                <ul>
                                    @foreach($recentActivities['vendor_applications'] as $app)
                                        <li>{{ $app->business_name ?? 'N/A' }} - {{ $app->status }} ({{ $app->created_at->format('Y-m-d') }})</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6>Recent Tasks</h6>
                                <ul>
                                    @foreach($recentActivities['tasks'] as $task)
                                        <li>{{ $task->title ?? 'Task' }} - {{ $task->status }} ({{ $task->created_at->format('Y-m-d') }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.reports.download') }}" class="btn btn-primary" target="_blank" rel="noopener">
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
body {
    background: #f4f6fa !important;
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
</style>
@endsection 