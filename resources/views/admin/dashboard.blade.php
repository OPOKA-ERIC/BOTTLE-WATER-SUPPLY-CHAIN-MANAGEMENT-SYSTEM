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
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
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
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
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
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
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
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
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
                        <div class="col-md-3 mb-3">
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
                        <div class="col-md-3 mb-3">
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
                        <div class="col-md-3 mb-3">
                            <a href="#" class="quick-action-card d-block text-center p-4">
                                <div class="quick-action-icon warning mb-2">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                </div>
                <div class="quick-action-content">
                    <h4>System Reports</h4>
                    <p>View analytics and performance data</p>
                </div>
            </a>
                        </div>
                        <div class="col-md-3 mb-3">
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
</style>
@endsection