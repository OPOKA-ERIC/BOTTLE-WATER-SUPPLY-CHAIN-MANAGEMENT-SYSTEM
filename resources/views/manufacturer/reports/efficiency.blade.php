<div class="efficiency-report">
    <!-- Report Header -->
    <div class="report-header">
        <h2 class="report-title">
            <i class="nc-icon nc-chart-bar-32"></i>
            Production Efficiency Report
        </h2>
        <div class="report-meta">
            <span class="generated-date">Generated on {{ date('F j, Y \a\t g:i A') }}</span>
        </div>
    </div>

    <!-- Key Metrics Row -->
    <div class="metrics-row">
        <div class="metric-card">
            <div class="metric-icon">
                <i class="nc-icon nc-chart-pie-35"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ number_format($efficiencyRate, 1) }}%</div>
                <div class="metric-label">Efficiency Rate</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="nc-icon nc-time-alarm"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ number_format($avgProductionTime, 1) }}h</div>
                <div class="metric-label">Avg Production Time</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="nc-icon nc-settings-gear-65"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ number_format($utilizationRate, 1) }}%</div>
                <div class="metric-label">Resource Utilization</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">
                <i class="nc-icon nc-box-2"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ $completedBatches }}/{{ $totalBatches }}</div>
                <div class="metric-label">Completed/Total Batches</div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="report-content">
        <!-- Left Column -->
        <div class="content-column">
            <!-- Monthly Production Trends -->
            <div class="report-section">
                <h3 class="section-title">
                    <i class="nc-icon nc-chart-line-1"></i>
                    Monthly Production Trends
                </h3>
                <div class="section-content">
                    @if($monthlyProduction->count() > 0)
                        <div class="trend-chart">
                            @foreach($monthlyProduction as $month)
                                <div class="trend-bar">
                                    <div class="bar-label">{{ date('M', mktime(0, 0, 0, $month->month, 1)) }}</div>
                                    <div class="bar-container">
                                        <div class="bar-fill" style="width: {{ ($month->count / $monthlyProduction->max('count')) * 100 }}%"></div>
                                    </div>
                                    <div class="bar-value">{{ $month->count }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <p class="text-muted">No production data available for this year.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Production Status Breakdown -->
            <div class="report-section">
                <h3 class="section-title">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    Production Status Breakdown
                </h3>
                <div class="section-content">
                    @if($statusBreakdown->count() > 0)
                        <div class="status-breakdown">
                            @foreach($statusBreakdown as $status)
                                <div class="status-item">
                                    <div class="status-info">
                                        <span class="status-badge status-{{ $status->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $status->status)) }}
                                        </span>
                                        <span class="status-count">{{ $status->count }}</span>
                                    </div>
                                    <div class="status-percentage">
                                        {{ $totalBatches > 0 ? number_format(($status->count / $totalBatches) * 100, 1) : 0 }}%
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <p class="text-muted">No production batches found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="content-column">
            <!-- Recent Activity -->
            <div class="report-section">
                <h3 class="section-title">
                    <i class="nc-icon nc-bell-55"></i>
                    Recent Activity
                </h3>
                <div class="section-content">
                    @if($recentActivity->count() > 0)
                        <div class="activity-list">
                            @foreach($recentActivity as $batch)
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="nc-icon nc-box-2"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title">
                                            Batch #{{ $batch->id }} - {{ $batch->product->name ?? 'Unknown Product' }}
                                        </div>
                                        <div class="activity-details">
                                            <span class="quantity">{{ number_format($batch->quantity) }} units</span>
                                            <span class="status-badge status-{{ $batch->status }}">
                                                {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                                            </span>
                                        </div>
                                        <div class="activity-time">
                                            {{ $batch->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <p class="text-muted">No recent activity found.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Efficiency Recommendations -->
            <div class="report-section">
                <h3 class="section-title">
                    <i class="nc-icon nc-light-3"></i>
                    Efficiency Recommendations
                </h3>
                <div class="section-content">
                    <div class="recommendations">
                        @if($efficiencyRate < 80)
                            <div class="recommendation-item warning">
                                <i class="nc-icon nc-alert-circle-i"></i>
                                <span>Production efficiency is below target. Consider optimizing production processes and reducing downtime.</span>
                            </div>
                        @endif
                        
                        @if($avgProductionTime > 24)
                            <div class="recommendation-item warning">
                                <i class="nc-icon nc-time-alarm"></i>
                                <span>Average production time is high. Review production workflows and identify bottlenecks.</span>
                            </div>
                        @endif
                        
                        @if($utilizationRate < 70)
                            <div class="recommendation-item info">
                                <i class="nc-icon nc-settings-gear-65"></i>
                                <span>Resource utilization is low. Consider increasing production capacity or optimizing scheduling.</span>
                            </div>
                        @endif
                        
                        @if($efficiencyRate >= 80 && $avgProductionTime <= 24 && $utilizationRate >= 70)
                            <div class="recommendation-item success">
                                <i class="nc-icon nc-check-2"></i>
                                <span>Excellent efficiency! Keep up the good work and maintain current processes.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.efficiency-report {
    font-family: 'Roboto', sans-serif;
    color: #333;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.report-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
}

.report-title {
    color: #2c3e50;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 10px;
}

.report-title i {
    margin-right: 10px;
    color: #3498db;
}

.report-meta {
    color: #7f8c8d;
    font-size: 14px;
}

.metrics-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.metric-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-5px);
}

.metric-icon {
    font-size: 2.5em;
    margin-right: 20px;
    opacity: 0.9;
}

.metric-value {
    font-size: 2em;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 5px;
}

.metric-label {
    font-size: 0.9em;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.report-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.content-column {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.report-section {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
}

.section-title {
    color: #2c3e50;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 10px;
    color: #3498db;
}

.trend-chart {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.trend-bar {
    display: flex;
    align-items: center;
    gap: 15px;
}

.bar-label {
    width: 40px;
    font-weight: 600;
    color: #2c3e50;
}

.bar-container {
    flex: 1;
    height: 20px;
    background: #ecf0f1;
    border-radius: 10px;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #3498db, #2980b9);
    border-radius: 10px;
    transition: width 0.3s ease;
}

.bar-value {
    width: 30px;
    text-align: right;
    font-weight: 600;
    color: #2c3e50;
}

.status-breakdown {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
}

.status-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8em;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending { background: #ffeaa7; color: #d63031; }
.status-in_progress { background: #74b9ff; color: white; }
.status-completed { background: #00b894; color: white; }
.status-cancelled { background: #fd79a8; color: white; }

.status-count {
    font-weight: 600;
    color: #2c3e50;
}

.status-percentage {
    font-weight: 600;
    color: #7f8c8d;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.activity-item {
    display: flex;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #3498db;
}

.activity-icon {
    font-size: 1.5em;
    color: #3498db;
    margin-top: 2px;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.activity-details {
    display: flex;
    gap: 10px;
    margin-bottom: 5px;
}

.quantity {
    color: #7f8c8d;
    font-size: 0.9em;
}

.activity-time {
    color: #95a5a6;
    font-size: 0.8em;
}

.recommendations {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.recommendation-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid;
}

.recommendation-item.warning {
    background: #fff3cd;
    border-left-color: #ffc107;
    color: #856404;
}

.recommendation-item.info {
    background: #d1ecf1;
    border-left-color: #17a2b8;
    color: #0c5460;
}

.recommendation-item.success {
    background: #d4edda;
    border-left-color: #28a745;
    color: #155724;
}

.recommendation-item i {
    margin-top: 2px;
    font-size: 1.2em;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #7f8c8d;
}

.empty-state p {
    margin: 0;
    font-style: italic;
}

@media (max-width: 768px) {
    .report-content {
        grid-template-columns: 1fr;
    }
    
    .metrics-row {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .efficiency-report {
        padding: 15px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Production Chart
    const monthlyCtx = document.getElementById('monthlyProductionChart').getContext('2d');
    const monthlyData = @json($monthlyProduction);
    
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const productionData = new Array(12).fill(0);
    
    monthlyData.forEach(item => {
        productionData[item.month - 1] = item.count;
    });

    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Production Batches',
                data: productionData,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Efficiency Chart
    const efficiencyCtx = document.getElementById('efficiencyChart').getContext('2d');
    const completed = {{ $completedBatches }};
    const total = {{ $totalBatches }};
    const pending = total - completed;

    new Chart(efficiencyCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending'],
            datasets: [{
                data: [completed, pending],
                backgroundColor: ['#28a745', '#ffc107'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script> 