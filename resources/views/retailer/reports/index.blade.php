@extends('layouts.app', ['activePage' => 'reports', 'title' => 'Retailer Reports'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Business Analytics & Reports</h1>
                        <p class="welcome-subtitle">Track your sales performance, analyze product trends, and monitor business growth</p>
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
                        <i class="nc-icon nc-money-coins"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">UGX {{ number_format($salesReport->sum('total')) }}</h3>
                        <p class="stats-label">Total Sales</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>All time</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-chart-pie-35"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $productReport->count() }}</h3>
                        <p class="stats-label">Products Sold</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Unique products</span>
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
                        <h3 class="stats-number">{{ $productReport->sum('total_quantity') }}</h3>
                        <p class="stats-label">Total Quantity</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Units sold</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">UGX {{ number_format($salesReport->avg('total')) }}</h3>
                        <p class="stats-label">Avg Daily Sales</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Per day</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Report -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Sales Performance</h4>
                            <p class="card-subtitle">Daily sales trends and performance metrics</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-money-coins"></i>
                        </div>
                </div>
                <div class="card-body">
                    @if($salesReport->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Total Sales</th>
                                            <th>Orders</th>
                                            <th>Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salesReport as $sale)
                                        <tr>
                                                <td>
                                                    <span class="date-label">{{ \Carbon\Carbon::parse($sale->date)->format('M d, Y') }}</span>
                                                </td>
                                                <td>
                                                    <span class="amount">UGX {{ number_format($sale->total) }}</span>
                                                </td>
                                                <td>
                                                    <span class="order-count">{{ $sale->orders_count ?? 1 }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $avgSales = $salesReport->avg('total');
                                                        $performance = $sale->total >= $avgSales ? 'above' : 'below';
                                                    @endphp
                                                    <span class="performance-badge performance-{{ $performance }}">
                                                        <i class="nc-icon {{ $performance == 'above' ? 'nc-chart-bar-32' : 'nc-chart-pie-35' }}"></i>
                                                        {{ $performance == 'above' ? 'Above Average' : 'Below Average' }}
                                                    </span>
                                                </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Sales Summary -->
                            <div class="summary-section">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <div class="summary-icon">
                                                <i class="nc-icon nc-money-coins"></i>
                                            </div>
                                            <div class="summary-content">
                                                <h5 class="summary-title">Total Revenue</h5>
                                                <p class="summary-value">UGX {{ number_format($salesReport->sum('total')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <div class="summary-icon">
                                                <i class="nc-icon nc-chart-bar-32"></i>
                                            </div>
                                            <div class="summary-content">
                                                <h5 class="summary-title">Average Daily Sales</h5>
                                                <p class="summary-value">UGX {{ number_format($salesReport->avg('total')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <div class="summary-icon">
                                                <i class="nc-icon nc-trophy"></i>
                                            </div>
                                            <div class="summary-content">
                                                <h5 class="summary-title">Best Day</h5>
                                                <p class="summary-value">{{ \Carbon\Carbon::parse($salesReport->max('date'))->format('M d, Y') }}</p>
                                                <p class="summary-subtitle">UGX {{ number_format($salesReport->max('total')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <h5 class="empty-title">No Sales Data Available</h5>
                                <p class="empty-subtitle">Complete your first order to start generating sales reports</p>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Performance -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                <div class="card-header">
                        <div class="header-content">
                    <h4 class="card-title">Product Performance</h4>
                            <p class="card-subtitle">Top selling products and revenue analysis</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                </div>
                <div class="card-body">
                    @if($productReport->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity Sold</th>
                                        <th>Revenue</th>
                                            <th>Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($productReport->take(10) as $index => $product)
                                        <tr>
                                                <td>
                                                    <div class="product-info">
                                                        <span class="product-name">{{ $product['name'] }}</span>
                                                        @if($index < 3)
                                                            <span class="top-seller-badge">
                                                                <i class="nc-icon nc-trophy"></i>
                                                                Top {{ $index + 1 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="quantity-label">{{ $product['total_quantity'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="amount">UGX {{ number_format($product['total_revenue']) }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $avgRevenue = $productReport->avg('total_revenue');
                                                        $performance = $product['total_revenue'] >= $avgRevenue ? 'excellent' : 'good';
                                                    @endphp
                                                    <span class="performance-badge performance-{{ $performance }}">
                                                        <i class="nc-icon {{ $performance == 'excellent' ? 'nc-trophy' : 'nc-chart-bar-32' }}"></i>
                                                        {{ $performance == 'excellent' ? 'Excellent' : 'Good' }}
                                                    </span>
                                                </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Product Summary -->
                            <div class="summary-section">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <div class="summary-icon">
                                                <i class="nc-icon nc-box-2"></i>
                                            </div>
                                            <div class="summary-content">
                                                <h5 class="summary-title">Total Products</h5>
                                                <p class="summary-value">{{ $productReport->count() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <div class="summary-icon">
                                                <i class="nc-icon nc-money-coins"></i>
                                            </div>
                                            <div class="summary-content">
                                                <h5 class="summary-title">Total Revenue</h5>
                                                <p class="summary-value">UGX {{ number_format($productReport->sum('total_revenue')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="summary-item">
                                            <div class="summary-icon">
                                                <i class="nc-icon nc-chart-pie-35"></i>
                                            </div>
                                            <div class="summary-content">
                                                <h5 class="summary-title">Total Quantity</h5>
                                                <p class="summary-value">{{ $productReport->sum('total_quantity') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <h5 class="empty-title">No Product Data Available</h5>
                                <p class="empty-subtitle">Start selling products to generate performance reports</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <!-- Sales Chart -->
        @if($salesReport->count() > 0)
        <div class="row">
        <div class="col-md-12">
                <div class="content-card">
                <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Sales Trend Analysis</h4>
                            <p class="card-subtitle">Visual representation of your sales performance over time</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                </div>
                <div class="card-body">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                        </div>
                </div>
            </div>
        </div>
        @endif
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

.date-label {
    font-weight: 600;
    color: #1976d2;
}

.amount {
    font-weight: 600;
    color: #2e7d32;
}

.order-count {
    font-weight: 600;
    color: #1976d2;
    background: rgba(25, 118, 210, 0.1);
    padding: 4px 8px;
    border-radius: 6px;
}

.quantity-label {
    font-weight: 600;
    color: #1976d2;
    background: rgba(25, 118, 210, 0.1);
    padding: 4px 8px;
    border-radius: 6px;
}

/* Product Info */
.product-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.product-name {
    font-weight: 600;
    color: #333;
}

.top-seller-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    background: linear-gradient(135deg, #ffd700, #ffed4e);
    color: #333;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.top-seller-badge i {
    font-size: 12px;
}

/* Performance Badges */
.performance-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.performance-above {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.performance-below {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.performance-excellent {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.performance-good {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

.performance-badge i {
    font-size: 12px;
}

/* Summary Section */
.summary-section {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.summary-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.summary-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.summary-icon i {
    font-size: 24px;
    color: white;
}

.summary-content {
    flex: 1;
}

.summary-title {
    font-size: 0.9rem;
    color: #666;
    margin: 0 0 5px 0;
    font-weight: 500;
}

.summary-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    margin: 0;
    line-height: 1.2;
}

.summary-subtitle {
    font-size: 0.85rem;
    color: #2e7d32;
    margin: 5px 0 0 0;
    font-weight: 600;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(25, 118, 210, 0.1);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 40px;
    color: #1976d2;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
}

.empty-subtitle {
    font-size: 1rem;
    color: #666;
    margin: 0;
}

/* Chart Container */
.chart-container {
    position: relative;
    height: 400px;
    margin-top: 20px;
}

/* Responsive Design */
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
    
    .summary-item {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .product-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}
</style>
@endsection

@push('js')
@if($salesReport->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function formatCurrency(amount) {
    return 'UGX ' + amount.toLocaleString();
}

function updateReportsUI(data) {
    // Update statistics cards
    document.querySelector('.stats-number[data-type="total-sales"]').textContent = formatCurrency(data.salesReport.reduce((sum, s) => sum + Number(s.total), 0));
    document.querySelector('.stats-number[data-type="products-sold"]').textContent = data.productReport.length;
    document.querySelector('.stats-number[data-type="total-quantity"]').textContent = data.productReport.reduce((sum, p) => sum + Number(p.total_quantity), 0);
    document.querySelector('.stats-number[data-type="avg-daily-sales"]').textContent = formatCurrency(data.salesReport.length ? (data.salesReport.reduce((sum, s) => sum + Number(s.total), 0) / data.salesReport.length) : 0);

    // Update sales table
    let salesTableBody = document.getElementById('sales-table-body');
    if (salesTableBody) {
        salesTableBody.innerHTML = '';
        data.salesReport.forEach(sale => {
            let avgSales = data.salesReport.length ? (data.salesReport.reduce((sum, s) => sum + Number(s.total), 0) / data.salesReport.length) : 0;
            let performance = sale.total >= avgSales ? 'above' : 'below';
            salesTableBody.innerHTML += `<tr>
                <td><span class="date-label">${new Date(sale.date).toLocaleDateString()}</span></td>
                <td><span class="amount">${formatCurrency(Number(sale.total))}</span></td>
                <td><span class="order-count">1</span></td>
                <td><span class="performance-badge performance-${performance}"><i class="nc-icon ${performance === 'above' ? 'nc-chart-bar-32' : 'nc-chart-pie-35'}"></i> ${performance === 'above' ? 'Above Average' : 'Below Average'}</span></td>
            </tr>`;
        });
    }
    // Update product table
    let productTableBody = document.getElementById('product-table-body');
    if (productTableBody) {
        productTableBody.innerHTML = '';
        data.productReport.slice(0, 10).forEach((product, index) => {
            let avgRevenue = data.productReport.length ? (data.productReport.reduce((sum, p) => sum + Number(p.total_revenue), 0) / data.productReport.length) : 0;
            let performance = product.total_revenue >= avgRevenue ? 'excellent' : 'good';
            productTableBody.innerHTML += `<tr>
                <td><div class="product-info"><span class="product-name">${product.name}</span>${index < 3 ? `<span class="top-seller-badge"><i class="nc-icon nc-trophy"></i> Top ${index + 1}</span>` : ''}</div></td>
                <td><span class="quantity-label">${product.total_quantity}</span></td>
                <td><span class="amount">${formatCurrency(Number(product.total_revenue))}</span></td>
                <td><span class="performance-badge performance-${performance}"><i class="nc-icon ${performance === 'excellent' ? 'nc-trophy' : 'nc-chart-bar-32'}"></i> ${performance === 'excellent' ? 'Excellent' : 'Good'}</span></td>
            </tr>`;
        });
    }
    // Update chart
    if (window.salesChartInstance) {
        window.salesChartInstance.data.labels = data.salesReport.map(s => new Date(s.date).toLocaleDateString());
        window.salesChartInstance.data.datasets[0].data = data.salesReport.map(s => Number(s.total));
        window.salesChartInstance.update();
    }
}

function fetchReportsData() {
    fetch('/retailer/reports/api')
        .then(res => res.json())
        .then(data => {
            updateReportsUI(data);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    // Add data-type attributes to stats cards for JS targeting
    document.querySelectorAll('.stats-number')[0].setAttribute('data-type', 'total-sales');
    document.querySelectorAll('.stats-number')[1].setAttribute('data-type', 'products-sold');
    document.querySelectorAll('.stats-number')[2].setAttribute('data-type', 'total-quantity');
    document.querySelectorAll('.stats-number')[3].setAttribute('data-type', 'avg-daily-sales');

    // Add IDs to table bodies for JS targeting
    let salesTable = document.querySelector('.table tbody');
    if (salesTable) salesTable.id = 'sales-table-body';
    let productTable = document.querySelectorAll('.table tbody')[1];
    if (productTable) productTable.id = 'product-table-body';

    // Setup chart.js for sales chart
    let salesChartCanvas = document.getElementById('salesChart');
    if (salesChartCanvas) {
        window.salesChartInstance = new Chart(salesChartCanvas.getContext('2d'), {
        type: 'line',
        data: {
                labels: [],
            datasets: [{
                    label: 'Sales',
                    data: [],
                    backgroundColor: 'rgba(102, 126, 234, 0.2)',
                    borderColor: '#667eea',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                    x: { display: true, title: { display: true, text: 'Date' } },
                    y: { display: true, title: { display: true, text: 'Sales (UGX)' } }
                }
            }
        });
    }
    // Initial fetch
    fetchReportsData();
    // Poll every 30 seconds
    setInterval(fetchReportsData, 30000);
});
</script>
@endif
@endpush 