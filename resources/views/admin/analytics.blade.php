@extends('layouts.app', ['activePage' => 'analytics', 'title' => 'Analytics - BWSCMS'])

@section('content')
<div class="content analytics-content-fix">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Welcome to Your Admin Analytics</h1>
                        <p class="welcome-subtitle">System analytics and business intelligence</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Statistics Cards Section -->
        <div class="row mb-4">
            <div class="col-md-2 col-6 mb-3">
                <div class="stats-card dashboard-stats-card">
                    <div class="stats-icon"><i class="nc-icon nc-single-02"></i></div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $stats['total_users'] ?? '-' }}</div>
                        <div class="stats-label">Total Users</div>
                        <div class="stats-updated">Updated just now</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <div class="stats-card dashboard-stats-card">
                    <div class="stats-icon"><i class="nc-icon nc-basket"></i></div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $stats['total_orders'] ?? '0' }}</div>
                        <div class="stats-label">Total Orders (2025)</div>
                        <div class="stats-updated">Updated just now</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <div class="stats-card dashboard-stats-card">
                    <div class="stats-icon"><i class="nc-icon nc-box"></i></div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $stats['total_inventory'] ?? '0' }}</div>
                        <div class="stats-label">Total Inventory</div>
                        <div class="stats-updated">Updated just now</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <div class="stats-card dashboard-stats-card">
                    <div class="stats-icon"><i class="nc-icon nc-badge"></i></div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $stats['total_vendor_applications'] ?? '-' }}</div>
                        <div class="stats-label">Total Vendor Applications</div>
                        <div class="stats-updated">Updated just now</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <div class="stats-card dashboard-stats-card">
                    <div class="stats-icon"><i class="nc-icon nc-paper"></i></div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $stats['total_tasks'] ?? '-' }}</div>
                        <div class="stats-label">Total Tasks</div>
                        <div class="stats-updated">Updated just now</div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-3">
                <div class="stats-card dashboard-stats-card">
                    <div class="stats-icon"><i class="nc-icon nc-bell-55"></i></div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $stats['urgent_tasks'] ?? '-' }}</div>
                        <div class="stats-label">Urgent Tasks</div>
                        <div class="stats-updated">Updated just now</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Key Performance Indicators Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="kpi-header">
                    <h3 class="mb-1">Key Performance Indicators</h3>
                    <p class="mb-0">Real-time business metrics and performance analytics</p>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-3 col-6 mb-3">
                <div class="kpi-card dashboard-kpi-card">
                    <div class="kpi-icon"><i class="nc-icon nc-money-coins"></i></div>
                    <div class="kpi-content">
                        <div class="kpi-number">{{ number_format($kpis['total_revenue'] ?? 0) }} UGX</div>
                        <div class="kpi-label">Total Revenue</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="kpi-card dashboard-kpi-card">
                    <div class="kpi-icon"><i class="nc-icon nc-delivery-fast"></i></div>
                    <div class="kpi-content">
                        <div class="kpi-number">{{ number_format($kpis['order_fulfillment_rate'] ?? 0, 1) }}%</div>
                        <div class="kpi-label">Order Fulfillment Rate</div>
                        <div class="kpi-status">{{ $kpis['order_fulfillment_rate'] > 90 ? 'On Target' : 'Needs Attention' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="kpi-card dashboard-kpi-card">
                    <div class="kpi-icon"><i class="nc-icon nc-box"></i></div>
                    <div class="kpi-content">
                        <div class="kpi-number">{{ number_format($kpis['inventory_turnover_rate'] ?? 0, 1) }}</div>
                        <div class="kpi-label">Inventory Turnover</div>
                        <div class="kpi-status">{{ $kpis['inventory_turnover_rate'] > 5 ? 'Good' : 'Needs Attention' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="kpi-card dashboard-kpi-card">
                    <div class="kpi-icon"><i class="nc-icon nc-chart-bar-32"></i></div>
                    <div class="kpi-content">
                        <div class="kpi-number">{{ number_format($kpis['user_growth_rate'] ?? 0, 1) }}%</div>
                        <div class="kpi-label">User Growth Rate</div>
                        <div class="kpi-status">{{ $kpis['user_growth_rate'] > 0 ? 'Growing' : 'Declining' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="kpi-card dashboard-kpi-card">
                    <div class="kpi-icon"><i class="nc-icon nc-time-alarm"></i></div>
                    <div class="kpi-content">
                        <div class="kpi-number">{{ number_format($kpis['average_order_processing_time'] ?? 0, 1) }}h</div>
                        <div class="kpi-label">Avg. Order Processing Time</div>
                        <div class="kpi-status">{{ $kpis['average_order_processing_time'] < 8 ? 'Fast' : 'Slow' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="kpi-card dashboard-kpi-card">
                    <div class="kpi-icon"><i class="nc-icon nc-check-2"></i></div>
                    <div class="kpi-content">
                        <div class="kpi-number">{{ number_format($kpis['task_completion_rate'] ?? 0, 1) }}%</div>
                        <div class="kpi-label">Task Completion Rate</div>
                        <div class="kpi-status">{{ $kpis['task_completion_rate'] > 80 ? 'Excellent' : 'Needs Improvement' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="kpi-card dashboard-kpi-card">
                    <div class="kpi-icon"><i class="nc-icon nc-badge"></i></div>
                    <div class="kpi-content">
                        <div class="kpi-number">{{ number_format($kpis['approval_rate'] ?? 0, 1) }}%</div>
                        <div class="kpi-label">Vendor Approval Rate</div>
                        <div class="kpi-status">{{ $kpis['approval_rate'] > 70 ? 'High Quality' : 'Strict Standards' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Quick Actions (optional, can be added if needed) -->
        <!-- Add more dashboard-like sections as needed -->
    </div>
</div>
<style>
.analytics-content-fix {
    margin-top: 90px !important;
    min-height: calc(100vh - 90px);
}
@media (max-width: 991px) {
    .analytics-content-fix {
        margin-top: 80px !important;
    }
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
.kpi-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    color: #fff;
    border-radius: 16px;
    padding: 28px 36px 18px 36px;
    margin-bottom: 18px;
    box-shadow: 0 4px 16px rgba(25, 118, 210, 0.10);
}
.kpi-header h3, .kpi-header p {
    color: #fff;
}
.stats-card, .stats-card.dashboard-stats-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
    padding: 1.5rem 1.2rem;
    display: flex;
    align-items: center;
    min-height: 120px;
    transition: box-shadow 0.2s, transform 0.2s;
    cursor: pointer;
}
.stats-card.dashboard-stats-card:hover {
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18), 0 2px 8px rgba(44, 62, 80, 0.07);
    transform: translateY(-4px) scale(1.03);
    z-index: 2;
}
.stats-icon {
    width: 48px;
    height: 48px;
    background: #e3e6f3;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: #1976d2;
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
.stats-updated {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 0.2rem;
}
.kpi-card, .kpi-card.dashboard-kpi-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
    padding: 1.5rem 1.2rem;
    display: flex;
    align-items: center;
    min-height: 120px;
    transition: box-shadow 0.2s, transform 0.2s;
    cursor: pointer;
}
.kpi-card.dashboard-kpi-card:hover {
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18), 0 2px 8px rgba(44, 62, 80, 0.07);
    transform: translateY(-4px) scale(1.03);
    z-index: 2;
}
.kpi-icon {
    width: 48px;
    height: 48px;
    background: #e3e6f3;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: #1976d2;
}
.kpi-content {
    flex: 1;
}
.kpi-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1a237e;
    margin-bottom: 0.2rem;
}
.kpi-label {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 0;
}
.kpi-status {
    font-size: 0.95rem;
    font-weight: 600;
    margin-top: 0.2rem;
    color: #1976d2;
}
@media (max-width: 768px) {
    .analytics-content-fix { padding-top: 120px !important; }
    .welcome-card { flex-direction: column; padding: 24px; text-align: center; }
    .welcome-content { margin-bottom: 18px; }
    .welcome-icon { margin: 20px 0 0 0; }
}
</style>
@endsection 