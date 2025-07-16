<div class="financial-report">
    <div class="report-header">
        <h3><i class="fas fa-chart-pie"></i> Financial Performance Report</h3>
        <p class="text-muted">Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="row">
        <!-- Key Financial Metrics -->
        <div class="col-md-3">
            <div class="metric-card revenue">
                <div class="metric-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="metric-content">
                    <h4>${{ number_format($totalRevenue, 2) }}</h4>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card costs">
                <div class="metric-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="metric-content">
                    <h4>${{ number_format($totalCosts, 2) }}</h4>
                    <p>Total Costs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card profit">
                <div class="metric-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="metric-content">
                    <h4>${{ number_format($totalProfit, 2) }}</h4>
                    <p>Net Profit</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="metric-card margin">
                <div class="metric-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="metric-content">
                    <h4>{{ number_format($profitMargin, 1) }}%</h4>
                    <p>Profit Margin</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Monthly Revenue Chart -->
        <div class="col-md-8">
            <div class="chart-card">
                <h5><i class="fas fa-chart-bar"></i> Monthly Revenue Trends</h5>
                <div class="chart-container">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Financial Summary -->
        <div class="col-md-4">
            <div class="summary-card">
                <h5><i class="fas fa-info-circle"></i> Financial Summary</h5>
                <div class="summary-item">
                    <span class="label">Average Order Value:</span>
                    <span class="value">${{ number_format($avgOrderValue, 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Total Orders:</span>
                    <span class="value">{{ \App\Models\Order::where('status', 'completed')->count() }}</span>
                </div>
                <div class="summary-item">
                    <span class="label">Revenue Growth:</span>
                    <span class="value {{ $profitMargin > 0 ? 'text-success' : 'text-danger' }}">
                        {{ $profitMargin > 0 ? '+' : '' }}{{ number_format($profitMargin, 1) }}%
                    </span>
                </div>
                <div class="summary-item">
                    <span class="label">Cost Ratio:</span>
                    <span class="value">{{ $totalRevenue > 0 ? number_format(($totalCosts / $totalRevenue) * 100, 1) : 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Top Selling Products -->
        <div class="col-md-6">
            <div class="chart-card">
                <h5><i class="fas fa-trophy"></i> Top Selling Products</h5>
                <div class="products-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Units Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->total_sold) }}</td>
                                <td>${{ number_format($product->revenue, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No sales data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Profit Analysis -->
        <div class="col-md-6">
            <div class="chart-card">
                <h5><i class="fas fa-chart-pie"></i> Revenue vs Costs Breakdown</h5>
                <div class="chart-container">
                    <canvas id="profitAnalysisChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Financial Insights -->
        <div class="col-12">
            <div class="insights-card">
                <h5><i class="fas fa-lightbulb"></i> Financial Insights</h5>
                <div class="insights-list">
                    @if($profitMargin > 20)
                        <div class="insight-item positive">
                            <i class="fas fa-check-circle"></i>
                            <span>Excellent profit margin of {{ number_format($profitMargin, 1) }}% indicates strong financial health.</span>
                        </div>
                    @elseif($profitMargin > 10)
                        <div class="insight-item neutral">
                            <i class="fas fa-info-circle"></i>
                            <span>Good profit margin of {{ number_format($profitMargin, 1) }}%. Consider cost optimization for better margins.</span>
                        </div>
                    @else
                        <div class="insight-item negative">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Low profit margin of {{ number_format($profitMargin, 1) }}%. Review pricing strategy and cost structure.</span>
                        </div>
                    @endif

                    @if($avgOrderValue > 100)
                        <div class="insight-item positive">
                            <i class="fas fa-arrow-up"></i>
                            <span>High average order value of ${{ number_format($avgOrderValue, 2) }} shows good customer spending.</span>
                        </div>
                    @else
                        <div class="insight-item neutral">
                            <i class="fas fa-chart-line"></i>
                            <span>Average order value of ${{ number_format($avgOrderValue, 2) }}. Consider upselling strategies.</span>
                        </div>
                    @endif

                    @if($totalRevenue > $totalCosts * 1.5)
                        <div class="insight-item positive">
                            <i class="fas fa-trending-up"></i>
                            <span>Strong revenue-to-cost ratio indicates efficient operations.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.financial-report {
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.report-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f8f9fa;
}

.report-header h3 {
    color: #2c3e50;
    margin-bottom: 5px;
}

.metric-card {
    color: white;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.metric-card:hover {
    transform: translateY(-5px);
}

.metric-card.revenue {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.metric-card.costs {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}

.metric-card.profit {
    background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
}

.metric-card.margin {
    background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
}

.metric-icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
    opacity: 0.8;
}

.metric-content h4 {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.metric-content p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.chart-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    height: 100%;
}

.chart-card h5 {
    color: #2c3e50;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chart-container {
    height: 300px;
    position: relative;
}

.summary-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    height: 100%;
}

.summary-card h5 {
    color: #2c3e50;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #dee2e6;
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-item .label {
    font-weight: 500;
    color: #6c757d;
}

.summary-item .value {
    font-weight: bold;
    color: #2c3e50;
}

.products-table {
    max-height: 300px;
    overflow-y: auto;
}

.products-table table {
    margin-bottom: 0;
}

.products-table th {
    background: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.insights-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid #007bff;
}

.insights-card h5 {
    color: #2c3e50;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.insights-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.insight-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 15px;
    background: white;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.insight-item.positive {
    border-left: 4px solid #28a745;
}

.insight-item.neutral {
    border-left: 4px solid #ffc107;
}

.insight-item.negative {
    border-left: 4px solid #dc3545;
}

.insight-item i {
    font-size: 1.2rem;
    margin-top: 2px;
}

.insight-item.positive i {
    color: #28a745;
}

.insight-item.neutral i {
    color: #ffc107;
}

.insight-item.negative i {
    color: #dc3545;
}

.insight-item span {
    flex: 1;
    line-height: 1.5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Revenue Chart
    const revenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    const revenueData = @json($monthlyRevenue);
    
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const revenueValues = new Array(12).fill(0);
    
    revenueData.forEach(item => {
        revenueValues[item.month - 1] = item.revenue;
    });

    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue',
                data: revenueValues,
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: '#28a745',
                borderWidth: 2
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
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
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

    // Profit Analysis Chart
    const profitCtx = document.getElementById('profitAnalysisChart').getContext('2d');
    const revenue = {{ $totalRevenue }};
    const costs = {{ $totalCosts }};

    new Chart(profitCtx, {
        type: 'doughnut',
        data: {
            labels: ['Revenue', 'Costs'],
            datasets: [{
                data: [revenue, costs],
                backgroundColor: ['#28a745', '#dc3545'],
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