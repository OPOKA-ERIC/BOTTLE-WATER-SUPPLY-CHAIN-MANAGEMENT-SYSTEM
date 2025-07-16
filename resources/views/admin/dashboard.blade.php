@extends('layouts.app', ['activePage' => 'dashboard-overview', 'title' => 'Admin Dashboard', 'navName' => 'Admin Dashboard'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
        <div class="welcome-card">
            <div class="welcome-content">
                        <h1 class="welcome-title">Welcome to Your Admin Dashboard</h1>
                        <p class="welcome-subtitle">Manage users, vendors, orders, and system analytics</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-settings-gear-64"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
        <div class="row g-4">
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-circle-09"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['total_users'] }}</h3>
                        <p class="stats-label">Total Users</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['pending_orders'] }}</h3>
                        <p class="stats-label">Pending Orders</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-box"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['total_inventory'] }}</h3>
                        <p class="stats-label">Total Inventory</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-paper"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['pending_vendor_applications'] }}</h3>
                        <p class="stats-label">Pending Vendor Applications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon task-stats">
                        <i class="nc-icon nc-briefcase-24"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['total_tasks'] }}</h3>
                        <p class="stats-label">Total Tasks</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon urgent-stats">
                        <i class="nc-icon nc-alert-circle-i"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['urgent_tasks'] }}</h3>
                        <p class="stats-label">Urgent Tasks</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional KPI Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="kpi-section">
                    <div class="section-header">
                        <h2><i class="nc-icon nc-chart-pie-35"></i> Key Performance Indicators</h2>
                        <p>Real-time business metrics and performance analytics</p>
                    </div>
                    
                    <!-- Financial KPIs -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="kpi-card financial">
                                <div class="kpi-icon">
                                    <i class="nc-icon nc-money-coins"></i>
                                </div>
                                <div class="kpi-content">
                                    <h3 class="kpi-value">${{ number_format($kpis['total_revenue'], 2) }}</h3>
                                    <p class="kpi-label">Total Revenue</p>
                                    <div class="kpi-trend {{ $kpis['revenue_growth_rate'] >= 0 ? 'positive' : 'negative' }}">
                                        <i class="nc-icon {{ $kpis['revenue_growth_rate'] >= 0 ? 'nc-chart-bar-32' : 'nc-chart-bar-32' }}"></i>
                                        <span>{{ number_format($kpis['revenue_growth_rate'], 1) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="kpi-card operational">
                                <div class="kpi-icon">
                                    <i class="nc-icon nc-check-2"></i>
                                </div>
                                <div class="kpi-content">
                                    <h3 class="kpi-value">{{ number_format($kpis['order_fulfillment_rate'], 1) }}%</h3>
                                    <p class="kpi-label">Order Fulfillment Rate</p>
                                    <div class="kpi-trend positive">
                                        <i class="nc-icon nc-chart-bar-32"></i>
                                        <span>On Target</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="kpi-card inventory">
                                <div class="kpi-icon">
                                    <i class="nc-icon nc-box"></i>
                                </div>
                                <div class="kpi-content">
                                    <h3 class="kpi-value">{{ number_format($kpis['inventory_turnover_rate'], 1) }}</h3>
                                    <p class="kpi-label">Inventory Turnover</p>
                                    <div class="kpi-trend {{ $kpis['inventory_turnover_rate'] > 5 ? 'positive' : 'warning' }}">
                                        <i class="nc-icon nc-chart-bar-32"></i>
                                        <span>{{ $kpis['inventory_turnover_rate'] > 5 ? 'Good' : 'Needs Attention' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="kpi-card user">
                                <div class="kpi-icon">
                                    <i class="nc-icon nc-circle-09"></i>
                                </div>
                                <div class="kpi-content">
                                    <h3 class="kpi-value">{{ number_format($kpis['user_growth_rate'], 1) }}%</h3>
                                    <p class="kpi-label">User Growth Rate</p>
                                    <div class="kpi-trend {{ $kpis['user_growth_rate'] >= 0 ? 'positive' : 'negative' }}">
                                        <i class="nc-icon nc-chart-bar-32"></i>
                                        <span>{{ $kpis['user_growth_rate'] >= 0 ? 'Growing' : 'Declining' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Performance KPIs -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="kpi-card performance">
                                <div class="kpi-icon">
                                    <i class="nc-icon nc-time-alarm"></i>
                                </div>
                                <div class="kpi-content">
                                    <h3 class="kpi-value">{{ $kpis['average_order_processing_time'] }}h</h3>
                                    <p class="kpi-label">Avg. Order Processing Time</p>
                                    <div class="kpi-trend {{ $kpis['average_order_processing_time'] < 24 ? 'positive' : 'warning' }}">
                                        <i class="nc-icon nc-chart-bar-32"></i>
                                        <span>{{ $kpis['average_order_processing_time'] < 24 ? 'Fast' : 'Slow' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="kpi-card task">
                                <div class="kpi-icon">
                                    <i class="nc-icon nc-briefcase-24"></i>
                                </div>
                                <div class="kpi-content">
                                    <h3 class="kpi-value">{{ number_format($kpis['task_completion_rate'], 1) }}%</h3>
                                    <p class="kpi-label">Task Completion Rate</p>
                                    <div class="kpi-trend {{ $kpis['task_completion_rate'] > 80 ? 'positive' : 'warning' }}">
                                        <i class="nc-icon nc-chart-bar-32"></i>
                                        <span>{{ $kpis['task_completion_rate'] > 80 ? 'Excellent' : 'Needs Improvement' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="kpi-card vendor">
                                <div class="kpi-icon">
                                    <i class="nc-icon nc-paper"></i>
                                </div>
                                <div class="kpi-content">
                                    <h3 class="kpi-value">{{ number_format($kpis['approval_rate'], 1) }}%</h3>
                                    <p class="kpi-label">Vendor Approval Rate</p>
                                    <div class="kpi-trend {{ $kpis['approval_rate'] > 70 ? 'positive' : 'warning' }}">
                                        <i class="nc-icon nc-chart-bar-32"></i>
                                        <span>{{ $kpis['approval_rate'] > 70 ? 'High Quality' : 'Strict Standards' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="quick-actions-section mb-4">
        <div class="section-header">
                        <h2><i class="nc-icon nc-bolt"></i> Quick Actions</h2>
            <p>Frequently used admin tools</p>
        </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('admin.work-distribution.index') }}" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon task-action mb-2">
                                    <i class="nc-icon nc-briefcase-24"></i>
                </div>
                <div class="quick-action-content">
                    <h4>Work Distribution</h4>
                    <p>Manage work assignments</p>
                </div>
            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('admin.work-distribution.create') }}" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon create-action mb-2">
                                    <i class="nc-icon nc-simple-add"></i>
                </div>
                <div class="quick-action-content">
                    <h4>Create Work Distribution</h4>
                    <p>Assign new work</p>
                </div>
            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('admin.vendors.applications') }}" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon primary mb-2">
                                    <i class="nc-icon nc-paper"></i>
                </div>
                <div class="quick-action-content">
                    <h4>Review Applications</h4>
                    <p>Approve or reject vendor applications</p>
                </div>
            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon success mb-2">
                                    <i class="nc-icon nc-circle-09"></i>
                </div>
                <div class="quick-action-content">
                    <h4>Manage Users</h4>
                    <p>Add, edit, or remove system users</p>
                </div>
            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('admin.analytics') }}" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon warning mb-2">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                </div>
                <div class="quick-action-content">
                    <h4>System Reports</h4>
                    <p>View analytics and performance data</p>
                </div>
            </a>
                        </div>
                        <div class="col-md-2 mb-3">
                            <a href="#" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon info mb-2">
                                    <i class="nc-icon nc-settings-gear-64"></i>
                </div>
                <div class="quick-action-content">
                    <h4>System Settings</h4>
                    <p>Configure application preferences</p>
                </div>
            </a>
                        </div>
                        <!-- Task Scheduling Quick Action -->
                        <div class="col-md-2 mb-3">
                            <a href="{{ route('admin.tasks.index') }}" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon primary mb-2">
                                    <i class="nc-icon nc-calendar-60"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h4>Task Scheduling</h4>
                                    <p>Schedule and track tasks</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
        </div>
    </div>

        <!-- Recent Orders -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Orders</h4>
                            <p class="card-subtitle">Latest orders and their status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                    <td><span class="order-id">#{{ $order->id }}</span></td>
                                        <td>{{ $order->retailer->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                        <td colspan="4" class="text-center">No recent orders found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

        <!-- Recent Vendor Applications -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Vendor Applications</h4>
                            <p class="card-subtitle">Latest vendor applications and their status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-paper"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Business Name</th>
                                    <th>Applicant</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentVendorApplications as $application)
                                    <tr>
                                        <td>{{ $application->business_name }}</td>
                                        <td>{{ $application->user->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $application->status }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                        <td colspan="4" class="text-center">No recent applications found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Work Distributions</h4>
                            <p class="card-subtitle">Latest work assignments and their progress</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-briefcase-24"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Assignee</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                        <td colspan="4" class="text-center">No recent work distributions found</td>
                                        </tr>
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
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-completed {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-pending {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-processing {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

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
}

.quick-actions-section {
    margin-bottom: 3rem;
}
.section-header {
    text-align: center;
    margin-bottom: 2rem;
}
.quick-action-card {
    background: rgba(255,255,255,0.95);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    color: inherit;
    text-decoration: none;
}
.quick-action-card:hover {
    box-shadow: 0 12px 40px rgba(102,126,234,0.15);
    transform: translateY(-3px);
    color: inherit;
    text-decoration: none;
}
.quick-action-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 10px auto;
}
.quick-action-icon.primary { background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; }
.quick-action-icon.success { background: linear-gradient(135deg, #4facfe, #00f2fe); color: #fff; }
.quick-action-icon.warning { background: linear-gradient(135deg, #f093fb, #f5576c); color: #fff; }
.quick-action-icon.info { background: linear-gradient(135deg, #43e97b, #38f9d7); color: #fff; }
.quick-action-content h4 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}
.quick-action-content p {
    color: #718096;
    margin: 0;
    font-size: 0.9rem;
}

.stats-icon.urgent-stats {
    background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
}

.stats-icon.task-stats {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.quick-action-icon.task-action {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.quick-action-icon.create-action {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

/* Task Table Styles */
.task-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.task-title {
    margin: 0;
    font-weight: 600;
    color: #333;
}

.task-title a {
    color: inherit;
    text-decoration: none;
}

.task-title a:hover {
    color: #667eea;
}

.task-category {
    font-size: 0.8rem;
    color: #666;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.assignee-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.assignee-name {
    font-weight: 500;
    color: #333;
}

.assignee-role {
    font-size: 0.8rem;
    color: #666;
    text-transform: capitalize;
}

.priority-badge, .status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
}

.priority-urgent { background: #ffebee; color: #c62828; }
.priority-high { background: #fff3e0; color: #ef6c00; }
.priority-medium { background: #e3f2fd; color: #1565c0; }
.priority-low { background: #e8f5e8; color: #2e7d32; }

.status-pending { background: #f3e5f5; color: #7b1fa2; }
.status-in_progress { background: #e1f5fe; color: #0277bd; }
.status-completed { background: #e8f5e8; color: #2e7d32; }
.status-cancelled { background: #ffebee; color: #c62828; }
.status-on_hold { background: #fff3e0; color: #ef6c00; }

.progress-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.progress {
    flex: 1;
    height: 6px;
    border-radius: 3px;
    background: #e9ecef;
}

.progress-text {
    font-size: 0.8rem;
    color: #666;
    min-width: 40px;
}

.due-date.overdue {
    color: #c62828;
    font-weight: 600;
}

.no-due-date {
    color: #999;
    font-style: italic;
}

.card-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 1rem;
}

/* KPI Section Styles */
.kpi-section {
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.kpi-section .section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.kpi-section .section-header h2 {
    color: #2d3748;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.kpi-section .section-header p {
    color: #718096;
    font-size: 1rem;
    margin: 0;
}

.kpi-card {
    background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    border: 1px solid rgba(255,255,255,0.8);
    position: relative;
    overflow: hidden;
}

.kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.kpi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(102,126,234,0.15);
}

.kpi-card.financial::before { background: linear-gradient(90deg, #4facfe, #00f2fe); }
.kpi-card.operational::before { background: linear-gradient(90deg, #43e97b, #38f9d7); }
.kpi-card.inventory::before { background: linear-gradient(90deg, #f093fb, #f5576c); }
.kpi-card.user::before { background: linear-gradient(90deg, #667eea, #764ba2); }
.kpi-card.performance::before { background: linear-gradient(90deg, #ff9a9e, #fecfef); }
.kpi-card.task::before { background: linear-gradient(90deg, #a8edea, #fed6e3); }
.kpi-card.vendor::before { background: linear-gradient(90deg, #ffecd2, #fcb69f); }

.kpi-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.kpi-card.financial .kpi-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.kpi-card.operational .kpi-icon { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.kpi-card.inventory .kpi-icon { background: linear-gradient(135deg, #f093fb, #f5576c); }
.kpi-card.user .kpi-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.kpi-card.performance .kpi-icon { background: linear-gradient(135deg, #ff9a9e, #fecfef); }
.kpi-card.task .kpi-icon { background: linear-gradient(135deg, #a8edea, #fed6e3); }
.kpi-card.vendor .kpi-icon { background: linear-gradient(135deg, #ffecd2, #fcb69f); }

.kpi-value {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
    line-height: 1;
}

.kpi-label {
    color: #718096;
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0 0 1rem 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.kpi-trend {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    background: rgba(255,255,255,0.8);
}

.kpi-trend.positive {
    color: #38a169;
    background: rgba(56, 161, 105, 0.1);
}

.kpi-trend.negative {
    color: #e53e3e;
    background: rgba(229, 62, 62, 0.1);
}

.kpi-trend.warning {
    color: #d69e2e;
    background: rgba(214, 158, 46, 0.1);
}

.kpi-trend i {
    font-size: 1rem;
}

/* Responsive KPI adjustments */
@media (max-width: 768px) {
    .kpi-section {
        padding: 1.5rem;
    }
    
    .kpi-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .kpi-value {
        font-size: 1.5rem;
    }
    
    .kpi-icon {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
}
</style>
@endsection