<div class="inventory-report">
    <!-- Report Header -->
    <div class="report-header mb-4">
        <h4 class="report-title">
            <i class="nc-icon nc-chart-bar-32"></i>
            Inventory Report
        </h4>
        <p class="report-meta">Generated on {{ now()->format('F d, Y \a\t g:i A') }}</p>
    </div>

    <!-- Key Statistics Cards -->
    <div class="stats-summary mb-4">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="summary-card total">
                    <div class="summary-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ number_format($stats['total_items']) }}</h4>
                        <p class="summary-label">Total Items</p>
                        <span class="summary-subtitle">In inventory</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="summary-card success">
                    <div class="summary-icon">
                        <i class="nc-icon nc-check-2"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ number_format($stats['total_stock']) }}</h4>
                        <p class="summary-label">Total Stock</p>
                        <span class="summary-subtitle">Units available</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="summary-card warning">
                    <div class="summary-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ number_format($stats['low_stock_items']) }}</h4>
                        <p class="summary-label">Low Stock</p>
                        <span class="summary-subtitle">Needs attention</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="summary-card critical">
                    <div class="summary-icon">
                        <i class="nc-icon nc-alert-circle-i"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ number_format($stats['out_of_stock_items']) }}</h4>
                        <p class="summary-label">Out of Stock</p>
                        <span class="summary-subtitle">Critical items</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card info">
                <div class="stat-icon">
                    <i class="nc-icon nc-chart-bar-32"></i>
                </div>
                <div class="stat-content">
                    <h5 class="stat-number">{{ number_format($stats['average_stock_level'], 1) }}</h5>
                    <p class="stat-label">Average Stock Level</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card primary">
                <div class="stat-icon">
                    <i class="nc-icon nc-settings-gear-65"></i>
                </div>
                <div class="stat-content">
                    <h5 class="stat-number">{{ number_format($stats['stock_utilization'], 1) }}%</h5>
                    <p class="stat-label">Stock Utilization</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card success">
                <div class="stat-icon">
                    <i class="nc-icon nc-check-2"></i>
                </div>
                <div class="stat-content">
                    <h5 class="stat-number">{{ number_format($stats['well_stocked_items']) }}</h5>
                    <p class="stat-label">Well Stocked Items</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Level Analysis -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="content-card">
                <div class="card-header">
                    <div class="header-content">
                        <h4 class="card-title">Stock Level Distribution</h4>
                        <p class="card-subtitle">Inventory status breakdown</p>
                    </div>
                    <div class="header-icon">
                        <i class="nc-icon nc-chart-pie-35"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="stock-level-item mb-3">
                        <div class="level-info">
                            <span class="level-badge critical">Critical</span>
                            <span class="level-description">Below minimum stock</span>
                        </div>
                        <span class="level-count">{{ $stockLevels['critical'] }} items</span>
                    </div>
                    <div class="stock-level-item mb-3">
                        <div class="level-info">
                            <span class="level-badge warning">Low</span>
                            <span class="level-description">Min - 1.5x minimum</span>
                        </div>
                        <span class="level-count">{{ $stockLevels['low'] }} items</span>
                    </div>
                    <div class="stock-level-item mb-3">
                        <div class="level-info">
                            <span class="level-badge info">Moderate</span>
                            <span class="level-description">1.5x - 3x minimum</span>
                        </div>
                        <span class="level-count">{{ $stockLevels['moderate'] }} items</span>
                    </div>
                    <div class="stock-level-item">
                        <div class="level-info">
                            <span class="level-badge success">Good</span>
                            <span class="level-description">Above 3x minimum</span>
                        </div>
                        <span class="level-count">{{ $stockLevels['good'] }} items</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-md-6 mb-4">
            <div class="content-card">
                <div class="card-header">
                    <div class="header-content">
                        <h4 class="card-title">Top Products by Stock</h4>
                        <p class="card-subtitle">Highest stock levels</p>
                    </div>
                    <div class="header-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                </div>
                <div class="card-body">
                    @if($topProducts->count() > 0)
                        @foreach($topProducts as $item)
                            <div class="product-item mb-3">
                                <div class="product-info">
                                    <h6 class="product-name">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                    <span class="product-stock">{{ number_format($item->current_stock) }} units</span>
                                </div>
                                <div class="product-status">
                                    <span class="status-badge success">Well Stocked</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <p class="text-muted">No products found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Turnover Analysis -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header">
                    <div class="header-content">
                        <h4 class="card-title">Stock Turnover Analysis</h4>
                        <p class="card-subtitle">Product turnover rates and efficiency</p>
                    </div>
                    <div class="header-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                </div>
                <div class="card-body">
                    @if(!empty($topTurnoverItems))
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Minimum Stock</th>
                                        <th>Turnover Rate</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topTurnoverItems as $item)
                                        @php
                                            $statusClass = $item['status'] === 'Critical' ? 'danger' : ($item['status'] === 'Low' ? 'warning' : ($item['status'] === 'Moderate' ? 'info' : 'success'));
                                        @endphp
                                        <tr>
                                            <td>{{ $item['product'] }}</td>
                                            <td>{{ number_format($item['current_stock']) }}</td>
                                            <td>{{ number_format($item['minimum_stock']) }}</td>
                                            <td>{{ number_format($item['turnover_rate'], 2) }}</td>
                                            <td><span class="status-badge {{ $statusClass }}">{{ $item['status'] }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <p class="text-muted">No turnover data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="content-card">
                <div class="card-header">
                    <div class="header-content">
                        <h4 class="card-title">Monthly Trends</h4>
                        <p class="card-subtitle">6-month inventory trends</p>
                    </div>
                    <div class="header-icon">
                        <i class="nc-icon nc-chart-line-1"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="trends-grid">
                        @foreach($monthlyTrends as $month => $data)
                            <div class="trend-item">
                                <div class="trend-header">
                                    <h6 class="trend-month">{{ $month }}</h6>
                                </div>
                                <div class="trend-stats">
                                    <div class="trend-stat">
                                        <span class="trend-value">{{ number_format($data['total_stock']) }}</span>
                                        <span class="trend-label">Total Stock</span>
                                    </div>
                                    <div class="trend-stat">
                                        <span class="trend-value">{{ number_format($data['items_count']) }}</span>
                                        <span class="trend-label">Items</span>
                                    </div>
                                    <div class="trend-stat">
                                        <span class="trend-value">{{ number_format($data['low_stock_count']) }}</span>
                                        <span class="trend-label">Low Stock</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-section">
        <div class="section-header">
            <h5 class="section-title">
                <i class="nc-icon nc-settings-gear-65"></i>
                Quick Actions
            </h5>
        </div>
        <div class="actions-grid">
            <button class="quick-action-btn" onclick="openStockAlertsModal()">
                <div class="action-icon">
                    <i class="nc-icon nc-bell-55"></i>
                </div>
                <div class="action-content">
                    <span class="action-title">View Stock Alerts</span>
                    <span class="action-subtitle">Check critical alerts</span>
                </div>
            </button>
            <button class="quick-action-btn" onclick="openBulkUpdateModal()">
                <div class="action-icon">
                    <i class="nc-icon nc-settings-gear-65"></i>
                </div>
                <div class="action-content">
                    <span class="action-title">Bulk Update</span>
                    <span class="action-subtitle">Update multiple items</span>
                </div>
            </button>
            <button class="quick-action-btn" onclick="downloadInventoryTemplate()">
                <div class="action-icon">
                    <i class="nc-icon nc-cloud-download-93"></i>
                </div>
                <div class="action-content">
                    <span class="action-title">Download Template</span>
                    <span class="action-subtitle">Get CSV template</span>
                </div>
            </button>
        </div>
    </div>
</div>

<style>
.inventory-report {
    font-family: 'Roboto', sans-serif;
    color: #2c3e50;
}

.report-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.report-title {
    color: #2c3e50;
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.report-meta {
    color: #6c757d;
    font-size: 0.9rem;
}

.summary-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.summary-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.summary-card.total {
    border-left: 4px solid #667eea;
}

.summary-card.success {
    border-left: 4px solid #28a745;
}

.summary-card.warning {
    border-left: 4px solid #ffc107;
}

.summary-card.critical {
    border-left: 4px solid #dc3545;
}

.summary-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.summary-card.total .summary-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.summary-card.success .summary-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.summary-card.warning .summary-icon {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.summary-card.critical .summary-icon {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.summary-content {
    flex: 1;
}

.summary-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
}

.summary-label {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    color: #495057;
}

.summary-subtitle {
    font-size: 0.75rem;
    color: #6c757d;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.stat-card.info .stat-icon {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.stat-card.primary .stat-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-card.success .stat-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
}

.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin: 0;
}

.content-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-content h4 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.header-content p {
    margin: 5px 0 0 0;
    opacity: 0.9;
    font-size: 0.9rem;
}

.header-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
}

.card-body {
    padding: 1.5rem;
}

.stock-level-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 0.75rem;
}

.level-info {
    display: flex;
    flex-direction: column;
}

.level-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.level-badge.critical {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.level-badge.warning {
    background: rgba(255, 193, 7, 0.1);
    color: #e0a800;
}

.level-badge.info {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.level-badge.success {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.level-description {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.level-count {
    font-weight: 600;
    color: #2c3e50;
}

.product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 0.75rem;
}

.product-info {
    display: flex;
    flex-direction: column;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 0.25rem 0;
}

.product-stock {
    font-size: 0.85rem;
    color: #6c757d;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.success {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-badge.warning {
    background: rgba(255, 193, 7, 0.1);
    color: #e0a800;
}

.status-badge.info {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.status-badge.danger {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.trends-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.trend-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
}

.trend-month {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.trend-stats {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.trend-stat {
    display: flex;
    flex-direction: column;
}

.trend-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2c3e50;
}

.trend-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.quick-actions-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #2c3e50;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.quick-action-btn {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 12px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: inherit;
}

.quick-action-btn:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
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
    margin-bottom: 0.25rem;
}

.action-subtitle {
    display: block;
    font-size: 0.8rem;
    color: #6c757d;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

@media (max-width: 768px) {
    .trends-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style> 