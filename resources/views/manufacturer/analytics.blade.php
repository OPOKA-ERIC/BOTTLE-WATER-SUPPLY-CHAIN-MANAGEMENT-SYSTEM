@extends('layouts.app', ['activePage' => 'analytics', 'title' => 'Manufacturer Analytics'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Manufacturing Analytics</h1>
                        <p class="welcome-subtitle">Comprehensive insights into production performance, efficiency metrics, and business intelligence</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-chart-pie-35"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $analytics['kpis']['efficiency'] }}%</h3>
                        <p class="stats-label">Efficiency Rate</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Production efficiency</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ number_format($analytics['kpis']['totalProduction']) }}</h3>
                        <p class="stats-label">Total Produced</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Units this month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-time-alarm"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $analytics['kpis']['avgCycleTime'] }}h</h3>
                        <p class="stats-label">Avg. Cycle Time</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Production time</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-money-coins"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ number_format($analytics['kpis']['avgPricePerUnit']) }}</h3>
                        <p class="stats-label">Avg. Price/Unit</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>UGX per unit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Quick Actions</h1>
                        <p class="welcome-subtitle">Generate reports and view analytics</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="quick-actions">
                    <button class="quick-action-btn" onclick="openProductionReportModal()">
                        <div class="action-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Production Report</span>
                            <span class="action-subtitle">Monthly production summary</span>
                        </div>
                    </button>
                    <button class="quick-action-btn" onclick="openInventoryReportModal()">
                        <div class="action-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Inventory Report</span>
                            <span class="action-subtitle">Stock levels and turnover</span>
                        </div>
                    </button>
                    <button class="quick-action-btn" onclick="openStockAlertsModal()">
                        <div class="action-icon">
                            <i class="nc-icon nc-bell-55"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Stock Alerts</span>
                            <span class="action-subtitle">View critical alerts</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Analytics Overview -->
        <div class="row">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Analytics Overview</h1>
                        <p class="welcome-subtitle">Key manufacturing metrics and performance indicators</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Overview Content -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="analytics-grid">
                    <div class="analytics-item">
                        <div class="analytics-icon">
                            <i class="nc-icon nc-chart-pie-35"></i>
                        </div>
                        <div class="analytics-content">
                            <h5 class="analytics-title">Production Trends</h5>
                            <p class="analytics-description">Track production volume and efficiency over time</p>
                            <div class="analytics-metric">
                                <span class="metric-value {{ $analytics['trends']['production'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $analytics['trends']['production'] >= 0 ? '+' : '' }}{{ $analytics['trends']['production'] }}%
                                </span>
                                <span class="metric-label">vs last month</span>
                            </div>
                        </div>
                    </div>
                    <div class="analytics-item">
                        <div class="analytics-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                        <div class="analytics-content">
                            <h5 class="analytics-title">Inventory Analytics</h5>
                            <p class="analytics-description">Monitor stock levels and turnover rates</p>
                            <div class="analytics-metric">
                                <span class="metric-value">{{ $analytics['kpis']['inventoryUtilization'] }}%</span>
                                <span class="metric-label">utilization rate</span>
                            </div>
                        </div>
                    </div>
                    <div class="analytics-item">
                        <div class="analytics-icon">
                            <i class="nc-icon nc-time-alarm"></i>
                        </div>
                        <div class="analytics-content">
                            <h5 class="analytics-title">Time Analysis</h5>
                            <p class="analytics-description">Production cycle times and downtime analysis</p>
                            <div class="analytics-metric">
                                <span class="metric-value {{ $analytics['trends']['cycleTime'] <= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $analytics['trends']['cycleTime'] }}%
                                </span>
                                <span class="metric-label">cycle time improvement</span>
                            </div>
                        </div>
                    </div>
                    <div class="analytics-item">
                        <div class="analytics-icon">
                            <i class="nc-icon nc-money-coins"></i>
                        </div>
                        <div class="analytics-content">
                            <h5 class="analytics-title">Revenue Analysis</h5>
                            <p class="analytics-description">Production revenue and profitability metrics</p>
                            <div class="analytics-metric">
                                <span class="metric-value">{{ number_format($analytics['kpis']['avgPricePerUnit']) }} UGX</span>
                                <span class="metric-label">avg. price per unit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Production Performance Chart -->
            <div class="col-lg-8 mb-4">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Production Performance</h1>
                        <p class="welcome-subtitle">Monthly production volume and efficiency trends</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Reports -->
            <div class="col-lg-4 mb-4">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Quick Reports</h1>
                        <p class="welcome-subtitle">Generate and download reports</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-single-copy-04"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Production Performance Content -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Monthly Production Volume</h5>
                                <p class="chart-description">Production trends over the last 4 months</p>
                            </div>
                            <div class="chart-content">
                                <div class="chart-bars">
                                    @foreach($analytics['monthlyProduction'] as $month => $production)
                                        @php
                                            $maxProduction = max($analytics['monthlyProduction']);
                                            $percentage = $maxProduction > 0 ? ($production / $maxProduction) * 100 : 0;
                                        @endphp
                                        <div class="chart-bar-item">
                                            <div class="bar-container">
                                                <div class="bar-fill" style="height: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="bar-label">{{ $month }}</span>
                                            <span class="bar-value">{{ number_format($production) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="chart-metrics">
                                    <div class="metric-item">
                                        <span class="metric-label">Total Production</span>
                                        <span class="metric-value">{{ number_format($analytics['kpis']['totalProduction']) }} units</span>
                                    </div>
                                    <div class="metric-item">
                                        <span class="metric-label">Average Monthly</span>
                                        <span class="metric-value">{{ number_format($analytics['kpis']['totalProduction'] > 0 ? $analytics['kpis']['totalProduction'] / 4 : 0) }} units</span>
                                    </div>
                                    <div class="metric-item">
                                        <span class="metric-label">Peak Month</span>
                                        <span class="metric-value">{{ number_format(max($analytics['monthlyProduction'])) }} units</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Reports Content -->
            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <div class="card-body">
                        <div class="reports-list">
                            <button class="report-btn" onclick="openProductionReportModal()">
                                <div class="report-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <div class="report-content">
                                    <span class="report-title">Production Report</span>
                                    <span class="report-subtitle">Monthly production summary</span>
                                </div>
                                <div class="report-action">
                                    <i class="nc-icon nc-single-copy-04"></i>
                                </div>
                            </button>
                            <button class="report-btn" onclick="openInventoryReportModal()">
                                <div class="report-icon">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <div class="report-content">
                                    <span class="report-title">Inventory Report</span>
                                    <span class="report-subtitle">Stock levels and turnover</span>
                                </div>
                                <div class="report-action">
                                    <i class="nc-icon nc-single-copy-04"></i>
                                </div>
                            </button>
                            <button class="report-btn" onclick="openEfficiencyReportModal()">
                                <div class="report-icon">
                                    <i class="nc-icon nc-time-alarm"></i>
                                </div>
                                <div class="report-content">
                                    <span class="report-title">Efficiency Report</span>
                                    <span class="report-subtitle">Performance metrics</span>
                                </div>
                                <div class="report-action">
                                    <i class="nc-icon nc-single-copy-04"></i>
                                </div>
                            </button>
                            <button class="report-btn" onclick="openFinancialReportModal()">
                                <div class="report-icon">
                                    <i class="nc-icon nc-money-coins"></i>
                                </div>
                                <div class="report-content">
                                    <span class="report-title">Financial Report</span>
                                    <span class="report-subtitle">Cost analysis and revenue</span>
                                </div>
                                <div class="report-action">
                                    <i class="nc-icon nc-single-copy-04"></i>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Performance Metrics -->
            <div class="col-lg-6 mb-4">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Top Performing Products</h1>
                        <p class="welcome-subtitle">Best performing products by volume</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chart-pie-35"></i>
                    </div>
                </div>
            </div>

            <!-- Recent Alerts -->
            <div class="col-lg-6 mb-4">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Recent Alerts</h1>
                        <p class="welcome-subtitle">Important notifications and warnings</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics Content -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="content-card">
                    <div class="card-body">
                        <div class="performance-list">
                            @forelse($analytics['topProducts'] as $productData)
                                @php
                                    $maxQuantity = $analytics['topProducts']->max('total_quantity');
                                    $percentage = $maxQuantity > 0 ? ($productData['total_quantity'] / $maxQuantity) * 100 : 0;
                                @endphp
                                <div class="performance-item">
                                    <div class="product-info">
                                        <div class="product-icon">
                                            <i class="nc-icon nc-box-2"></i>
                                        </div>
                                        <div class="product-details">
                                            <span class="product-name">{{ $productData['product']->name ?? 'Unknown Product' }}</span>
                                            <span class="product-volume">{{ number_format($productData['total_quantity']) }} units</span>
                                        </div>
                                    </div>
                                    <div class="performance-bar">
                                        <div class="bar-fill" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="performance-percentage">{{ round($percentage) }}%</span>
                                </div>
                            @empty
                                <div class="empty-performance">
                                    <div class="empty-icon">
                                        <i class="nc-icon nc-box-2"></i>
                                    </div>
                                    <h6 class="empty-title">No Production Data</h6>
                                    <p class="empty-subtitle">No completed production batches found yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Alerts Content -->
            <div class="col-lg-6 mb-4">
                <div class="content-card">
                    <div class="card-body">
                        <div class="alerts-list">
                            @forelse($analytics['recentAlerts'] as $alert)
                                <div class="alert-item {{ $alert['type'] }}">
                                    <div class="alert-icon">
                                        <i class="{{ $alert['icon'] }}"></i>
                                    </div>
                                    <div class="alert-content">
                                        <h6 class="alert-title">{{ $alert['title'] }}</h6>
                                        <p class="alert-message">{{ $alert['message'] }}</p>
                                        <span class="alert-time">{{ $alert['time'] }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-alerts">
                                    <div class="empty-icon">
                                        <i class="nc-icon nc-bell-55"></i>
                                    </div>
                                    <h6 class="empty-title">No Alerts</h6>
                                    <p class="empty-subtitle">Everything is running smoothly!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Revenue Summary</h1>
                        <p class="welcome-subtitle">Real-time revenue breakdown and financial insights</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-money-coins"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Summary Content -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-body">
                        <div class="revenue-summary">
                            <div class="revenue-item">
                                <div class="revenue-icon">
                                    <i class="nc-icon nc-money-coins"></i>
                                </div>
                                <div class="revenue-content">
                                    <h5 class="revenue-title">Total Revenue</h5>
                                    <div class="revenue-amount">
                                        <span class="amount-ugx">{{ number_format($analytics['kpis']['revenue']) }} UGX</span>
                                        <span class="amount-usd">≈ ${{ number_format($analytics['kpis']['revenue'] / 3800, 2) }} USD</span>
                                    </div>
                                    <p class="revenue-description">From {{ number_format($analytics['kpis']['totalProduction']) }} units produced</p>
                                </div>
                            </div>
                            <div class="revenue-item">
                                <div class="revenue-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <div class="revenue-content">
                                    <h5 class="revenue-title">Average Price</h5>
                                    <div class="revenue-amount">
                                        <span class="amount-ugx">{{ number_format($analytics['kpis']['avgPricePerUnit']) }} UGX</span>
                                        <span class="amount-usd">per unit</span>
                                    </div>
                                    <p class="revenue-description">Weighted average across all products</p>
                                </div>
                            </div>
                            <div class="revenue-item">
                                <div class="revenue-icon">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                </div>
                                <div class="revenue-content">
                                    <h5 class="revenue-title">Production Value</h5>
                                    <div class="revenue-amount">
                                        <span class="amount-ugx">{{ number_format($analytics['kpis']['totalProduction'] * $analytics['kpis']['avgPricePerUnit']) }} UGX</span>
                                        <span class="amount-usd">potential revenue</span>
                                    </div>
                                    <p class="revenue-description">Based on current production volume</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Content Adjustments */
.content {
    padding-top: 100px !important;
    margin-top: 0;
}

/* Welcome Section */
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 40px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
    margin-bottom: 30px;
}

.welcome-content {
    flex: 1;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0 0 15px 0;
    font-weight: 300;
}

.welcome-icon {
    font-size: 4rem;
    opacity: 0.8;
    margin-left: 30px;
}

.real-time-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    opacity: 0.8;
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 12px;
    border-radius: 20px;
    backdrop-filter: blur(10px);
}

.real-time-indicator i {
    font-size: 0.8rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.real-time-indicator.live {
    background: rgba(39, 174, 96, 0.2);
    color: #27ae60;
}

.real-time-indicator.updating {
    background: rgba(52, 152, 219, 0.2);
    color: #3498db;
}

.real-time-indicator.error {
    background: rgba(231, 76, 60, 0.2);
    color: #e74c3c;
}

.refresh-btn {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 4px;
    border-radius: 50%;
    transition: all 0.3s ease;
    margin-left: 8px;
}

.refresh-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(180deg);
}

.refresh-btn:active {
    transform: rotate(360deg);
}

.refresh-btn i {
    font-size: 0.8rem;
}

.refresh-btn.spinning i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Statistics Cards */
.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 5px;
}

.stats-label {
    font-size: 1rem;
    color: #7f8c8d;
    margin-bottom: 15px;
    font-weight: 500;
}

.stats-footer {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    color: #95a5a6;
}

.stats-footer i {
    margin-right: 8px;
    font-size: 0.9rem;
}

/* Content Cards */
.content-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    margin-bottom: 30px;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-content h4 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
}

.header-content p {
    margin: 5px 0 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.header-icon {
    font-size: 2rem;
    opacity: 0.8;
}

.card-body {
    padding: 30px;
}

/* Analytics Grid */
.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

.analytics-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.analytics-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.analytics-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.analytics-content {
    flex: 1;
}

.analytics-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.analytics-description {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 15px;
    line-height: 1.4;
}

.analytics-metric {
    display: flex;
    align-items: baseline;
    gap: 8px;
}

.metric-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: #27ae60;
}

.metric-label {
    font-size: 0.8rem;
    color: #95a5a6;
}

/* Chart Container */
.chart-container {
    min-height: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.chart-header {
    text-align: center;
    padding: 20px;
    margin-bottom: 20px;
}

.chart-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.chart-description {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0;
}

.chart-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.chart-bars {
    display: flex;
    flex-direction: column;
    gap: 15px;
    width: 100%;
    margin-bottom: 30px;
}

.chart-bar-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    width: 100%;
    transition: all 0.3s ease;
}

.chart-bar-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.bar-container {
    flex: 1;
    height: 20px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.bar-label {
    font-size: 0.8rem;
    color: #7f8c8d;
    min-width: 60px;
}

.bar-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    min-width: 80px;
    text-align: right;
}

.chart-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    width: 100%;
}

.metric-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    text-align: center;
}

.metric-label {
    font-size: 0.85rem;
    color: #7f8c8d;
    margin-bottom: 8px;
}

.metric-value {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
}

/* Empty States */
.empty-performance,
.empty-alerts {
    text-align: center;
    padding: 40px 20px;
}

.empty-icon {
    width: 60px;
    height: 60px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 1.5rem;
    color: #667eea;
}

.empty-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.empty-subtitle {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0;
}

/* Text Colors for Trends */
.text-success {
    color: #27ae60 !important;
}

.text-danger {
    color: #e74c3c !important;
}

/* Currency and Tooltip Styling */
.stats-number[title] {
    cursor: help;
    position: relative;
}

.stats-number[title]:hover::after {
    content: attr(title);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.8rem;
    white-space: nowrap;
    z-index: 1000;
    margin-bottom: 5px;
}

.stats-number[title]:hover::before {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: rgba(0, 0, 0, 0.8);
    margin-bottom: -5px;
}

/* Currency indicator */
.currency-indicator {
    font-size: 0.7rem;
    color: #7f8c8d;
    font-weight: 400;
    margin-left: 5px;
}

/* Reports List */
.reports-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.report-btn {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    border: none;
    width: 100%;
}

.report-btn:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    color: inherit;
    text-decoration: none;
}

.report-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.report-content {
    flex: 1;
}

.report-title {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
    margin-bottom: 3px;
}

.report-subtitle {
    display: block;
    color: #7f8c8d;
    font-size: 0.85rem;
}

.report-action {
    color: #667eea;
    font-size: 1.2rem;
}

/* Performance List */
.performance-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.performance-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.product-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.product-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
}

.product-details {
    display: flex;
    flex-direction: column;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.product-volume {
    color: #7f8c8d;
    font-size: 0.8rem;
}

.performance-bar {
    flex: 1;
    height: 8px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin: 0 15px;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.performance-percentage {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
    min-width: 35px;
}

/* Alerts List */
.alerts-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.alert-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.alert-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.alert-item.warning {
    border-left: 4px solid #f39c12;
}

.alert-item.success {
    border-left: 4px solid #27ae60;
}

.alert-item.info {
    border-left: 4px solid #3498db;
}

.alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.alert-item.warning .alert-icon {
    background: #f39c12;
}

.alert-item.success .alert-icon {
    background: #27ae60;
}

.alert-item.info .alert-icon {
    background: #3498db;
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.alert-message {
    color: #7f8c8d;
    font-size: 0.85rem;
    margin-bottom: 8px;
    line-height: 1.4;
}

.alert-time {
    font-size: 0.75rem;
    color: #95a5a6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-card {
        flex-direction: column;
        text-align: center;
        padding: 30px 20px;
    }
    
    .welcome-icon {
        margin-left: 0;
        margin-top: 20px;
        font-size: 3rem;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .stats-card {
        padding: 20px;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .header-icon {
        align-self: flex-end;
    }
    
    .analytics-grid {
        grid-template-columns: 1fr;
    }
    
    .chart-bars {
        gap: 10px;
    }
    
    .chart-bar-item {
        padding: 12px;
        gap: 10px;
    }
    
    .bar-label {
        font-size: 0.75rem;
        min-width: 50px;
    }
    
    .bar-value {
        font-size: 1rem;
        min-width: 70px;
    }
    
    .chart-metrics {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .metric-item {
        padding: 15px;
    }
    
    .performance-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .performance-bar {
        width: 100%;
        margin: 0;
    }
}

@media (max-width: 576px) {
    .content {
        padding-top: 80px !important;
    }
    
    .welcome-title {
        font-size: 1.8rem;
    }
    
    .stats-card {
        padding: 15px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .analytics-item {
        padding: 20px;
    }
    
    .report-btn {
        padding: 15px;
    }
}

/* Revenue Summary */
.revenue-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.revenue-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.revenue-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.revenue-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.revenue-content {
    flex: 1;
}

.revenue-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.revenue-amount {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 10px;
}

.amount-ugx {
    font-size: 1.4rem;
    font-weight: 700;
    color: #27ae60;
}

.amount-usd {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

.revenue-description {
    color: #7f8c8d;
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.4;
}

/* Production Report Modal Styles */
#productionReportModal .modal-dialog {
    max-width: 95%;
}

#productionReportModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

#productionReportModal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
}

#productionReportModal .modal-title {
    font-weight: 600;
}

#productionReportModal .modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

/* Production Report Content Styles */
.production-report {
    padding: 20px 0;
}

.report-header {
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 20px;
}

.metric-card {
    transition: all 0.3s ease;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.metric-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.status-breakdown .status-item {
    padding: 10px;
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.02);
    transition: all 0.3s ease;
}

.status-breakdown .status-item:hover {
    background: rgba(0, 0, 0, 0.05);
    transform: translateX(5px);
}

.performance-metrics .metric-item {
    padding: 10px;
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.02);
    transition: all 0.3s ease;
}

.performance-metrics .metric-item:hover {
    background: rgba(0, 0, 0, 0.05);
}

.chart-bars {
    padding: 20px 0;
}

.chart-bar-item {
    transition: all 0.3s ease;
}

.chart-bar-item:hover {
    transform: translateY(-5px);
}

.bar-fill {
    transition: height 0.3s ease;
}

.top-products .product-item {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.top-products .product-item:hover {
    background: rgba(0, 0, 0, 0.05);
    transform: translateX(5px);
}

.recent-activity .activity-item {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.recent-activity .activity-item:hover {
    background: rgba(0, 0, 0, 0.05);
    transform: translateX(5px);
}

.summary-content {
    background: rgba(0, 0, 0, 0.02);
    border-radius: 10px;
    padding: 20px;
}

.summary-section, .recommendations-section {
    padding: 15px;
    border-radius: 8px;
    background: white;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.recommendations-section ul li {
    padding: 8px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.recommendations-section ul li:last-child {
    border-bottom: none;
}

/* Badge Styles */
.badge {
    font-size: 0.75rem;
    padding: 5px 10px;
    border-radius: 15px;
}

.badge-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
}

.badge-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.badge-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

/* Card Styles */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 15px 15px 0 0;
}

.card-header h6 {
    color: #2c3e50;
    font-weight: 600;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    border: none;
    width: 100%;
}

.quick-action-btn:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    color: inherit;
    text-decoration: none;
}

.action-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.action-content {
    flex: 1;
}

.action-title {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
    margin-bottom: 3px;
}

.action-subtitle {
    display: block;
    color: #7f8c8d;
    font-size: 0.85rem;
}
</style>

<script>
// Real-time analytics functionality
$(document).ready(function() {
    // Auto-refresh analytics data every 30 seconds
    setInterval(refreshAnalytics, 30000);
    
    // Initialize tooltips and other interactive elements
    initializeAnalytics();
    
    // Set initial real-time indicator
    updateRealTimeIndicator('live', 'Real-time data • Last updated: Just now');
});

// Function to update real-time indicator
function updateRealTimeIndicator(status, message) {
    const $indicator = $('.real-time-indicator');
    const $message = $('#last-updated');
    
    $indicator.removeClass('live updating error').addClass(status);
    $message.text(message);
}

// Manual refresh function
function manualRefresh() {
    const $btn = $('.refresh-btn');
    $btn.addClass('spinning');
    
    refreshAnalytics();
    
    // Remove spinning class after animation
    setTimeout(() => {
        $btn.removeClass('spinning');
    }, 1000);
}

// Function to refresh analytics data
function refreshAnalytics() {
    // Show updating status
    updateRealTimeIndicator('updating', 'Updating data...');
    
    $.ajax({
        url: '{{ route("manufacturer.analytics") }}',
        type: 'GET',
        success: function(response) {
            if (response.analytics && response.analytics.kpis) {
                // Validate data before updating
                const kpis = response.analytics.kpis;
                const trends = response.analytics.trends;
                const monthlyProduction = response.analytics.monthlyProduction;
                const topProducts = response.analytics.topProducts;
                const recentAlerts = response.analytics.recentAlerts;
                
                // Update KPIs with validation
                if (kpis.efficiency !== undefined) updateKPIs(kpis);
                if (trends) updateTrends(trends);
                if (monthlyProduction) updateChartData(monthlyProduction);
                if (topProducts) updateTopProducts(topProducts);
                if (recentAlerts) updateAlerts(recentAlerts);
                
                // Update revenue summary
                updateRevenueSummary(kpis);
                
                // Update real-time indicator
                const now = new Date().toLocaleTimeString();
                updateRealTimeIndicator('live', `Real-time data • Last updated: ${now}`);
                
                console.log('Analytics data refreshed successfully at', now);
            } else {
                updateRealTimeIndicator('error', 'Error: Invalid data received');
                console.error('Invalid response format');
            }
        },
        error: function(xhr, status, error) {
            updateRealTimeIndicator('error', 'Error: Failed to update data');
            console.error('Failed to refresh analytics data:', error);
        }
    });
}

// Update KPI values
function updateKPIs(kpis) {
    $('.stats-number').each(function() {
        const $element = $(this);
        const currentValue = $element.text();
        
        // Update specific KPIs based on their position or data attributes
        if (currentValue.includes('%') && !currentValue.includes('$') && !currentValue.includes('UGX')) {
            $element.text(kpis.efficiency + '%');
        } else if (currentValue.includes('UGX')) {
            // Update revenue in UGX with USD tooltip
            const revenueUGX = kpis.revenue.toLocaleString();
            const revenueUSD = (kpis.revenue / 3800).toFixed(2);
            $element.text(revenueUGX + ' UGX').attr('title', `USD: $${revenueUSD}`);
        } else if (currentValue.includes('h')) {
            $element.text(kpis.avgCycleTime + 'h');
        } else {
            $element.text(kpis.totalProduction.toLocaleString());
        }
    });
}

// Update trend indicators
function updateTrends(trends) {
    // Update production trend
    const productionTrend = $('.analytics-item:first .metric-value');
    const productionClass = trends.production >= 0 ? 'text-success' : 'text-danger';
    const productionSign = trends.production >= 0 ? '+' : '';
    productionTrend.removeClass('text-success text-danger').addClass(productionClass)
        .text(productionSign + trends.production + '%');
    
    // Update cycle time trend
    const cycleTimeTrend = $('.analytics-item:nth-child(3) .metric-value');
    const cycleTimeClass = trends.cycleTime <= 0 ? 'text-success' : 'text-danger';
    cycleTimeTrend.removeClass('text-success text-danger').addClass(cycleTimeClass)
        .text(trends.cycleTime + '%');
}

// Update chart data
function updateChartData(monthlyProduction) {
    const maxProduction = Math.max(...Object.values(monthlyProduction));
    
    Object.entries(monthlyProduction).forEach(([month, production], index) => {
        const percentage = maxProduction > 0 ? (production / maxProduction) * 100 : 0;
        const $barItem = $('.chart-bar-item').eq(index);
        
        if ($barItem.length) {
            $barItem.find('.bar-fill').css('height', percentage + '%');
            $barItem.find('.bar-value').text(production.toLocaleString());
        }
    });
}

// Update top products
function updateTopProducts(topProducts) {
    const $performanceList = $('.performance-list');
    $performanceList.empty();
    
    if (topProducts.length === 0) {
        $performanceList.html(`
            <div class="empty-performance">
                <div class="empty-icon">
                    <i class="nc-icon nc-box-2"></i>
                </div>
                <h6 class="empty-title">No Production Data</h6>
                <p class="empty-subtitle">No completed production batches found yet.</p>
            </div>
        `);
        return;
    }
    
    const maxQuantity = Math.max(...topProducts.map(p => p.total_quantity));
    
    topProducts.forEach(productData => {
        const percentage = maxQuantity > 0 ? (productData.total_quantity / maxQuantity) * 100 : 0;
        const productHtml = `
            <div class="performance-item">
                <div class="product-info">
                    <div class="product-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="product-details">
                        <span class="product-name">${productData.product ? productData.product.name : 'Unknown Product'}</span>
                        <span class="product-volume">${productData.total_quantity.toLocaleString()} units</span>
                    </div>
                </div>
                <div class="performance-bar">
                    <div class="bar-fill" style="width: ${percentage}%"></div>
                </div>
                <span class="performance-percentage">${Math.round(percentage)}%</span>
            </div>
        `;
        $performanceList.append(productHtml);
    });
}

// Update alerts
function updateAlerts(alerts) {
    const $alertsList = $('.alerts-list');
    $alertsList.empty();
    
    if (alerts.length === 0) {
        $alertsList.html(`
            <div class="empty-alerts">
                <div class="empty-icon">
                    <i class="nc-icon nc-bell-55"></i>
                </div>
                <h6 class="empty-title">No Alerts</h6>
                <p class="empty-subtitle">Everything is running smoothly!</p>
            </div>
        `);
        return;
    }
    
    alerts.forEach(alert => {
        const alertHtml = `
            <div class="alert-item ${alert.type}">
                <div class="alert-icon">
                    <i class="${alert.icon}"></i>
                </div>
                <div class="alert-content">
                    <h6 class="alert-title">${alert.title}</h6>
                    <p class="alert-message">${alert.message}</p>
                    <span class="alert-time">${alert.time}</span>
                </div>
            </div>
        `;
        $alertsList.append(alertHtml);
    });
}

// Update revenue summary
function updateRevenueSummary(kpis) {
    // Update total revenue
    const totalRevenueUGX = kpis.revenue.toLocaleString();
    const totalRevenueUSD = (kpis.revenue / 3800).toFixed(2);
    $('.revenue-item:first .amount-ugx').text(totalRevenueUGX + ' UGX');
    $('.revenue-item:first .amount-usd').text('≈ $' + totalRevenueUSD + ' USD');
    $('.revenue-item:first .revenue-description').text(`From ${kpis.totalProduction.toLocaleString()} units produced`);
    
    // Update average price
    const avgPriceUGX = kpis.avgPricePerUnit.toLocaleString();
    $('.revenue-item:nth-child(2) .amount-ugx').text(avgPriceUGX + ' UGX');
    $('.revenue-item:nth-child(2) .revenue-description').text('Weighted average across all products');
    
    // Update production value
    const productionValue = (kpis.totalProduction * kpis.avgPricePerUnit).toLocaleString();
    $('.revenue-item:nth-child(3) .amount-ugx').text(productionValue + ' UGX');
    $('.revenue-item:nth-child(3) .revenue-description').text('Based on current production volume');
}

// Initialize analytics page
function initializeAnalytics() {
    // Add hover effects to chart bars
    $('.chart-bar-item').hover(
        function() {
            $(this).addClass('hover');
        },
        function() {
            $(this).removeClass('hover');
        }
    );
    
    // Add click handlers for report buttons
    $('.report-btn').click(function() {
        const reportType = $(this).find('.report-title').text();
        generateReport(reportType);
    });
    
    // Add smooth animations
    $('.stats-card').addClass('animate-in');
    $('.analytics-item').addClass('animate-in');
}

// Generate reports (placeholder function)
function generateReport(reportType) {
    const reportTypes = {
        'Production Report': 'production',
        'Inventory Report': 'inventory',
        'Efficiency Report': 'efficiency',
        'Financial Report': 'financial'
    };
    
    const type = reportTypes[reportType] || 'general';
    
    // Show loading state
    const $btn = $(`.report-btn:contains("${reportType}")`);
    const originalContent = $btn.html();
    $btn.html('<i class="nc-icon nc-refresh-69 fa-spin"></i> Generating...');
    
    // Simulate report generation
    setTimeout(() => {
        $btn.html(originalContent);
        
        // Show report modal or download
        alert(`${reportType} generated successfully!\n\nThis would typically:\n• Download a PDF report\n• Show detailed analytics\n• Include charts and graphs\n• Provide actionable insights`);
    }, 2000);
}

// Add CSS animations
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .animate-in {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .chart-bar-item.hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
    `)
    .appendTo('head');
</script>

<!-- Inventory Report Modal -->
<div class="modal fade" id="inventoryReportModal" tabindex="-1" role="dialog" aria-labelledby="inventoryReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryReportModalLabel">Inventory Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="inventoryReportContent">
                <!-- Report content will be loaded here via AJAX -->
                <div class="text-center text-muted">Loading report...</div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Alerts Modal -->
<div class="modal fade" id="stockAlertsModal" tabindex="-1" role="dialog" aria-labelledby="stockAlertsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockAlertsModalLabel">Stock Alerts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="stockAlertsContent">
                <!-- Stock alerts will be loaded here via AJAX -->
                <div class="text-center text-muted">Loading stock alerts...</div>
            </div>
        </div>
    </div>
</div>

<!-- Production Report Modal -->
<div class="modal fade" id="productionReportModal" tabindex="-1" role="dialog" aria-labelledby="productionReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productionReportModalLabel">Production Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productionReportContent">
                <!-- Production report will be loaded here via AJAX -->
                <div class="text-center text-muted">Loading production report...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadProductionReport()">
                    <i class="nc-icon nc-single-copy-04"></i>
                    Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Efficiency Report Modal -->
<div class="modal fade" id="efficiencyReportModal" tabindex="-1" role="dialog" aria-labelledby="efficiencyReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="efficiencyReportModalLabel">Production Efficiency Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="efficiencyReportContent">
                <!-- Efficiency report will be loaded here via AJAX -->
                <div class="text-center text-muted">Loading efficiency report...</div>
            </div>
        </div>
    </div>
</div>

<!-- Financial Report Modal -->
<div class="modal fade" id="financialReportModal" tabindex="-1" role="dialog" aria-labelledby="financialReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="financialReportModalLabel">Financial Performance Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="financialReportContent">
                <!-- Financial report will be loaded here via AJAX -->
                <div class="text-center text-muted">Loading financial report...</div>
            </div>
        </div>
    </div>
</div>

<script>
// Inventory Report (AJAX)
function openInventoryReportModal() {
    console.log('Opening inventory report modal...');
    $('#inventoryReportModal').modal('show');
    $('#inventoryReportContent').html('<div class="text-center text-muted"><i class="nc-icon nc-refresh-69 fa-spin fa-2x mb-3"></i><p>Loading report...</p></div>');
    
    $.ajax({
        url: '{{ route("manufacturer.inventory.report") }}',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Inventory report response:', response);
            if (response.success) {
                $('#inventoryReportContent').html(response.html);
            } else {
                $('#inventoryReportContent').html('<div class="text-danger">' + (response.message || 'Failed to load report') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to load inventory report:', xhr.status, xhr.statusText);
            let errorMessage = 'Failed to load report';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Report endpoint not found';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            $('#inventoryReportContent').html('<div class="text-danger">' + errorMessage + '</div>');
        }
    });
}

// Production Report (AJAX)
function openProductionReportModal() {
    console.log('Opening production report modal...');
    $('#productionReportModal').modal('show');
    $('#productionReportContent').html('<div class="text-center text-muted"><i class="nc-icon nc-refresh-69 fa-spin fa-2x mb-3"></i><p>Loading production report...</p></div>');
    
    $.ajax({
        url: '{{ route("manufacturer.production.report") }}',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Production report response:', response);
            if (response.success) {
                $('#productionReportContent').html(response.html);
            } else {
                $('#productionReportContent').html('<div class="text-danger">' + (response.message || 'Failed to load production report') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to load production report:', xhr.status, xhr.statusText);
            let errorMessage = 'Failed to load production report';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Production report endpoint not found';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            $('#productionReportContent').html('<div class="text-danger">' + errorMessage + '</div>');
        }
    });
}

// Download production report function
function downloadProductionReport() {
    console.log('Downloading production report...');
    // For now, just show a message. In a real implementation, this would generate and download a PDF
    alert('PDF download feature will be implemented soon. For now, you can print this page using Ctrl+P.');
}

// Download report function
function downloadReport() {
    console.log('Downloading report...');
    // For now, just show a message. In a real implementation, this would generate and download a PDF
    alert('PDF download feature will be implemented soon. For now, you can print this page using Ctrl+P.');
}

// Stock Alerts (AJAX)
function openStockAlertsModal() {
    console.log('Opening stock alerts modal...');
    $('#stockAlertsModal').modal('show');
    $('#stockAlertsContent').html('<div class="text-center text-muted"><i class="nc-icon nc-refresh-69 fa-spin fa-2x mb-3"></i><p>Loading alerts...</p></div>');
    
    $.ajax({
        url: '{{ route("manufacturer.inventory.alerts") }}',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Stock alerts response:', response);
            if (response.success) {
                $('#stockAlertsContent').html(response.html);
            } else {
                $('#stockAlertsContent').html('<div class="text-danger">' + (response.message || 'Failed to load alerts') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to load stock alerts:', xhr.status, xhr.statusText);
            let errorMessage = 'Failed to load alerts';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Alerts endpoint not found';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            $('#stockAlertsContent').html('<div class="text-danger">' + errorMessage + '</div>');
        }
    });
}

// Alert action handlers
function handleAlertAction(productName, action) {
    console.log('Handling alert action:', productName, action);
    alert('Action "' + action + '" for ' + productName + ' will be implemented soon.');
}

function generateRestockList() {
    console.log('Generating restock list...');
    alert('Restock list generation will be implemented soon.');
}

function exportAlerts() {
    console.log('Exporting alerts...');
    alert('Alert export feature will be implemented soon.');
}

function scheduleAlerts() {
    console.log('Scheduling alerts...');
    alert('Alert scheduling feature will be implemented soon.');
}

function refreshAlerts() {
    console.log('Refreshing alerts...');
    openStockAlertsModal();
}

// Efficiency Report (AJAX)
function openEfficiencyReportModal() {
    console.log('Opening efficiency report modal...');
    $('#efficiencyReportModal').modal('show');
    $('#efficiencyReportContent').html('<div class="text-center text-muted"><i class="nc-icon nc-refresh-69 fa-spin fa-2x mb-3"></i><p>Loading efficiency report...</p></div>');
    
    $.ajax({
        url: '{{ route("efficiency.report") }}',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Efficiency report response:', response);
            if (response.success) {
                $('#efficiencyReportContent').html(response.html);
            } else {
                $('#efficiencyReportContent').html('<div class="text-danger">' + (response.message || 'Failed to load efficiency report') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to load efficiency report:', xhr.status, xhr.statusText);
            let errorMessage = 'Failed to load efficiency report';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Efficiency report endpoint not found';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            $('#efficiencyReportContent').html('<div class="text-danger">' + errorMessage + '</div>');
        }
    });
}

// Financial Report (AJAX)
function openFinancialReportModal() {
    console.log('Opening financial report modal...');
    $('#financialReportModal').modal('show');
    $('#financialReportContent').html('<div class="text-center text-muted"><i class="nc-icon nc-refresh-69 fa-spin fa-2x mb-3"></i><p>Loading financial report...</p></div>');
    
    $.ajax({
        url: '{{ route("financial.report") }}',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Financial report response:', response);
            if (response.success) {
                $('#financialReportContent').html(response.html);
            } else {
                $('#financialReportContent').html('<div class="text-danger">' + (response.message || 'Failed to load financial report') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Failed to load financial report:', xhr.status, xhr.statusText);
            let errorMessage = 'Failed to load financial report';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Financial report endpoint not found';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            $('#financialReportContent').html('<div class="text-danger">' + errorMessage + '</div>');
        }
    });
}
</script>
@endsection