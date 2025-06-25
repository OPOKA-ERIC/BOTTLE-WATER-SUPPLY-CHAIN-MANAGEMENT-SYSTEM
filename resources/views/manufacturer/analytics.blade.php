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

        <!-- Key Performance Indicators -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">94.2%</h3>
                        <p class="stats-label">Production Efficiency</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>This month</span>
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
                        <h3 class="stats-number">12,450</h3>
                        <p class="stats-label">Units Produced</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Last 30 days</span>
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
                        <h3 class="stats-number">2.3h</h3>
                        <p class="stats-label">Avg. Cycle Time</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Per batch</span>
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
                        <h3 class="stats-number">$45,230</h3>
                        <p class="stats-label">Revenue Generated</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>This month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Analytics Overview</h4>
                            <p class="card-subtitle">Key manufacturing metrics and performance indicators</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="analytics-grid">
                            <div class="analytics-item">
                                <div class="analytics-icon">
                                    <i class="nc-icon nc-chart-pie-35"></i>
                                </div>
                                <div class="analytics-content">
                                    <h5 class="analytics-title">Production Trends</h5>
                                    <p class="analytics-description">Track production volume and efficiency over time</p>
                                    <div class="analytics-metric">
                                        <span class="metric-value">+12.5%</span>
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
                                        <span class="metric-value">85%</span>
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
                                        <span class="metric-value">-8.2%</span>
                                        <span class="metric-label">cycle time improvement</span>
                                    </div>
                                </div>
                            </div>
                            <div class="analytics-item">
                                <div class="analytics-icon">
                                    <i class="nc-icon nc-money-coins"></i>
                                </div>
                                <div class="analytics-content">
                                    <h5 class="analytics-title">Cost Analysis</h5>
                                    <p class="analytics-description">Production costs and profitability metrics</p>
                                    <div class="analytics-metric">
                                        <span class="metric-value">$2.15</span>
                                        <span class="metric-label">cost per unit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Production Performance Chart -->
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Production Performance</h4>
                            <p class="card-subtitle">Monthly production volume and efficiency trends</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <div class="chart-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <h5 class="chart-title">Production Volume Chart</h5>
                                <p class="chart-description">Interactive chart showing production trends over the last 12 months</p>
                                <div class="chart-metrics">
                                    <div class="metric-item">
                                        <span class="metric-label">Total Production</span>
                                        <span class="metric-value">145,230 units</span>
                                    </div>
                                    <div class="metric-item">
                                        <span class="metric-label">Average Daily</span>
                                        <span class="metric-value">4,841 units</span>
                                    </div>
                                    <div class="metric-item">
                                        <span class="metric-label">Peak Day</span>
                                        <span class="metric-value">6,250 units</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Reports -->
            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Quick Reports</h4>
                            <p class="card-subtitle">Generate and download reports</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-single-copy-04"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="reports-list">
                            <button class="report-btn">
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
                            <button class="report-btn">
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
                            <button class="report-btn">
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
                            <button class="report-btn">
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

        <!-- Performance Metrics -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Top Performing Products</h4>
                            <p class="card-subtitle">Best performing products by volume</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-pie-35"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="performance-list">
                            <div class="performance-item">
                                <div class="product-info">
                                    <div class="product-icon">
                                        <i class="nc-icon nc-box-2"></i>
                                    </div>
                                    <div class="product-details">
                                        <span class="product-name">Bottled Water 500ml</span>
                                        <span class="product-volume">5,240 units</span>
                                    </div>
                                </div>
                                <div class="performance-bar">
                                    <div class="bar-fill" style="width: 85%"></div>
                                </div>
                                <span class="performance-percentage">85%</span>
                            </div>
                            <div class="performance-item">
                                <div class="product-info">
                                    <div class="product-icon">
                                        <i class="nc-icon nc-box-2"></i>
                                    </div>
                                    <div class="product-details">
                                        <span class="product-name">Bottled Water 1L</span>
                                        <span class="product-volume">4,180 units</span>
                                    </div>
                                </div>
                                <div class="performance-bar">
                                    <div class="bar-fill" style="width: 68%"></div>
                                </div>
                                <span class="performance-percentage">68%</span>
                            </div>
                            <div class="performance-item">
                                <div class="product-info">
                                    <div class="product-icon">
                                        <i class="nc-icon nc-box-2"></i>
                                    </div>
                                    <div class="product-details">
                                        <span class="product-name">Bottled Water 2L</span>
                                        <span class="product-volume">3,030 units</span>
                                    </div>
                                </div>
                                <div class="performance-bar">
                                    <div class="bar-fill" style="width: 49%"></div>
                                </div>
                                <span class="performance-percentage">49%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Alerts -->
            <div class="col-lg-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Alerts</h4>
                            <p class="card-subtitle">Important notifications and warnings</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-bell-55"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alerts-list">
                            <div class="alert-item warning">
                                <div class="alert-icon">
                                    <i class="nc-icon nc-alert-circle-i"></i>
                                </div>
                                <div class="alert-content">
                                    <h6 class="alert-title">Low Inventory Alert</h6>
                                    <p class="alert-message">Plastic bottles running low. Reorder recommended.</p>
                                    <span class="alert-time">2 hours ago</span>
                                </div>
                            </div>
                            <div class="alert-item success">
                                <div class="alert-icon">
                                    <i class="nc-icon nc-check-2"></i>
                                </div>
                                <div class="alert-content">
                                    <h6 class="alert-title">Production Target Met</h6>
                                    <p class="alert-message">Monthly production target achieved ahead of schedule.</p>
                                    <span class="alert-time">1 day ago</span>
                                </div>
                            </div>
                            <div class="alert-item info">
                                <div class="alert-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <div class="alert-content">
                                    <h6 class="alert-title">Efficiency Improvement</h6>
                                    <p class="alert-message">Production efficiency increased by 8.2% this week.</p>
                                    <span class="alert-time">3 days ago</span>
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
    margin: 0;
    font-weight: 300;
}

.welcome-icon {
    font-size: 4rem;
    opacity: 0.8;
    margin-left: 30px;
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
    align-items: center;
    justify-content: center;
}

.chart-placeholder {
    text-align: center;
    padding: 40px;
}

.chart-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
}

.chart-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.chart-description {
    color: #7f8c8d;
    margin-bottom: 30px;
    font-size: 0.95rem;
}

.chart-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
}

.metric-item {
    text-align: center;
    padding: 15px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.metric-item .metric-label {
    display: block;
    font-size: 0.8rem;
    color: #7f8c8d;
    margin-bottom: 5px;
}

.metric-item .metric-value {
    display: block;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
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
    
    .chart-metrics {
        grid-template-columns: 1fr;
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
</style>
@endsection 