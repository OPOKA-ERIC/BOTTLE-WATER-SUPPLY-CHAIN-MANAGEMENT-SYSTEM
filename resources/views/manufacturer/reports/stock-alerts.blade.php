<div class="stock-alerts">
    <!-- Alerts Summary Cards -->
    <div class="alerts-summary mb-4">
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="summary-card critical">
                    <div class="summary-icon">
                        <i class="nc-icon nc-alert-circle-i"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ $lowStockItems->where('current_stock', '<=', 10)->count() }}</h4>
                        <p class="summary-label">Critical Alerts</p>
                        <span class="summary-subtitle">Stock ≤ 10 units</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="summary-card warning">
                    <div class="summary-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ $lowStockItems->where('current_stock', '>', 10)->where('current_stock', '<=', 50)->count() }}</h4>
                        <p class="summary-label">Warning Alerts</p>
                        <span class="summary-subtitle">Stock 11-50 units</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="summary-card info">
                    <div class="summary-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ $lowStockItems->where('current_stock', '>', 50)->where('current_stock', '<=', 100)->count() }}</h4>
                        <p class="summary-label">Info Alerts</p>
                        <span class="summary-subtitle">Stock 51-100 units</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="summary-card total">
                    <div class="summary-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="summary-content">
                        <h4 class="summary-number">{{ $lowStockItems->count() }}</h4>
                        <p class="summary-label">Total Alerts</p>
                        <span class="summary-subtitle">All low stock items</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($lowStockItems->count() > 0)
        <!-- Critical Alerts -->
        @if($lowStockItems->where('current_stock', '<=', 10)->count() > 0)
            <div class="alert-section mb-4">
                <div class="section-header critical">
                    <h5 class="section-title">
                        <i class="nc-icon nc-alert-circle-i"></i>
                        Critical Alerts
                    </h5>
                    <span class="section-count">{{ $lowStockItems->where('current_stock', '<=', 10)->count() }} items</span>
                </div>
                <div class="alerts-grid">
                    @foreach($lowStockItems->where('current_stock', '<=', 10) as $item)
                        <div class="alert-card critical">
                            <div class="alert-header">
                                <div class="alert-icon">
                                    <i class="nc-icon nc-alert-circle-i"></i>
                                </div>
                                <div class="alert-priority">
                                    <span class="priority-badge critical">Critical</span>
                                </div>
                            </div>
                            <div class="alert-body">
                                <h6 class="product-name">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                <div class="stock-info">
                                    <div class="stock-level">
                                        <span class="current-stock">{{ number_format($item->current_stock) }}</span>
                                        <span class="stock-label">Current Stock</span>
                                    </div>
                                    <div class="stock-level">
                                        <span class="minimum-stock">{{ number_format($item->minimum_stock) }}</span>
                                        <span class="stock-label">Minimum Required</span>
                                    </div>
                                </div>
                                <div class="stock-progress">
                                    <div class="progress-bar">
                                        @php
                                            $percentage = $item->minimum_stock > 0 ? min(100, ($item->current_stock / $item->minimum_stock) * 100) : 0;
                                        @endphp
                                        <div class="progress-fill critical" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="progress-text">{{ number_format($percentage, 1) }}% of required stock</span>
                                </div>
                            </div>
                            <div class="alert-actions">
                                <button class="action-btn primary" onclick="reorderProduct({{ $item->product->id ?? 0 }})">
                                    <i class="nc-icon nc-simple-add"></i>
                                    Reorder Now
                                </button>
                                <button class="action-btn secondary" onclick="viewProductDetails({{ $item->product->id ?? 0 }})">
                                    <i class="nc-icon nc-zoom-split-in"></i>
                                    View Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Warning Alerts -->
        @if($lowStockItems->where('current_stock', '>', 10)->where('current_stock', '<=', 50)->count() > 0)
            <div class="alert-section mb-4">
                <div class="section-header warning">
                    <h5 class="section-title">
                        <i class="nc-icon nc-bell-55"></i>
                        Warning Alerts
                    </h5>
                    <span class="section-count">{{ $lowStockItems->where('current_stock', '>', 10)->where('current_stock', '<=', 50)->count() }} items</span>
                </div>
                <div class="alerts-grid">
                    @foreach($lowStockItems->where('current_stock', '>', 10)->where('current_stock', '<=', 50) as $item)
                        <div class="alert-card warning">
                            <div class="alert-header">
                                <div class="alert-icon">
                                    <i class="nc-icon nc-bell-55"></i>
                                </div>
                                <div class="alert-priority">
                                    <span class="priority-badge warning">Warning</span>
                                </div>
                            </div>
                            <div class="alert-body">
                                <h6 class="product-name">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                <div class="stock-info">
                                    <div class="stock-level">
                                        <span class="current-stock">{{ number_format($item->current_stock) }}</span>
                                        <span class="stock-label">Current Stock</span>
                                    </div>
                                    <div class="stock-level">
                                        <span class="minimum-stock">{{ number_format($item->minimum_stock) }}</span>
                                        <span class="stock-label">Minimum Required</span>
                                    </div>
                                </div>
                                <div class="stock-progress">
                                    <div class="progress-bar">
                                        @php
                                            $percentage = $item->minimum_stock > 0 ? min(100, ($item->current_stock / $item->minimum_stock) * 100) : 0;
                                        @endphp
                                        <div class="progress-fill warning" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="progress-text">{{ number_format($percentage, 1) }}% of required stock</span>
                                </div>
                            </div>
                            <div class="alert-actions">
                                <button class="action-btn primary" onclick="reorderProduct({{ $item->product->id ?? 0 }})">
                                    <i class="nc-icon nc-simple-add"></i>
                                    Reorder Now
                                </button>
                                <button class="action-btn secondary" onclick="viewProductDetails({{ $item->product->id ?? 0 }})">
                                    <i class="nc-icon nc-zoom-split-in"></i>
                                    View Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Info Alerts -->
        @if($lowStockItems->where('current_stock', '>', 50)->where('current_stock', '<=', 100)->count() > 0)
            <div class="alert-section mb-4">
                <div class="section-header info">
                    <h5 class="section-title">
                        <i class="nc-icon nc-chart-bar-32"></i>
                        Info Alerts
                    </h5>
                    <span class="section-count">{{ $lowStockItems->where('current_stock', '>', 50)->where('current_stock', '<=', 100)->count() }} items</span>
                </div>
                <div class="alerts-grid">
                    @foreach($lowStockItems->where('current_stock', '>', 50)->where('current_stock', '<=', 100) as $item)
                        <div class="alert-card info">
                            <div class="alert-header">
                                <div class="alert-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <div class="alert-priority">
                                    <span class="priority-badge info">Info</span>
                                </div>
                            </div>
                            <div class="alert-body">
                                <h6 class="product-name">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                <div class="stock-info">
                                    <div class="stock-level">
                                        <span class="current-stock">{{ number_format($item->current_stock) }}</span>
                                        <span class="stock-label">Current Stock</span>
                                    </div>
                                    <div class="stock-level">
                                        <span class="minimum-stock">{{ number_format($item->minimum_stock) }}</span>
                                        <span class="stock-label">Minimum Required</span>
                                    </div>
                                </div>
                                <div class="stock-progress">
                                    <div class="progress-bar">
                                        @php
                                            $percentage = $item->minimum_stock > 0 ? min(100, ($item->current_stock / $item->minimum_stock) * 100) : 0;
                                        @endphp
                                        <div class="progress-fill info" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="progress-text">{{ number_format($percentage, 1) }}% of required stock</span>
                                </div>
                            </div>
                            <div class="alert-actions">
                                <button class="action-btn primary" onclick="reorderProduct({{ $item->product->id ?? 0 }})">
                                    <i class="nc-icon nc-simple-add"></i>
                                    Reorder Now
                                </button>
                                <button class="action-btn secondary" onclick="viewProductDetails({{ $item->product->id ?? 0 }})">
                                    <i class="nc-icon nc-zoom-split-in"></i>
                                    View Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <div class="section-header">
                <h5 class="section-title">
                    <i class="nc-icon nc-settings-gear-65"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="actions-grid">
                <button class="quick-action-btn" onclick="reorderAllCritical()">
                    <div class="action-icon">
                        <i class="nc-icon nc-simple-add"></i>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Reorder All Critical</span>
                        <span class="action-subtitle">Create orders for critical items</span>
                    </div>
                </button>
                <button class="quick-action-btn" onclick="generateReorderReport()">
                    <div class="action-icon">
                        <i class="nc-icon nc-single-copy-04"></i>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Generate Report</span>
                        <span class="action-subtitle">Export reorder recommendations</span>
                    </div>
                </button>
                <button class="quick-action-btn" onclick="updateStockLevels()">
                    <div class="action-icon">
                        <i class="nc-icon nc-ruler-pencil"></i>
                    </div>
                    <div class="action-content">
                        <span class="action-title">Update Levels</span>
                        <span class="action-subtitle">Adjust minimum stock levels</span>
                    </div>
                </button>
            </div>
        </div>
    @else
        <!-- No Alerts State -->
        <div class="no-alerts-state">
            <div class="no-alerts-icon">
                <i class="nc-icon nc-check-2"></i>
            </div>
            <h4 class="no-alerts-title">No Stock Alerts</h4>
            <p class="no-alerts-message">All inventory items are well-stocked and above minimum levels.</p>
            <div class="no-alerts-actions">
                <button class="action-btn primary" onclick="viewInventory()">
                    <i class="nc-icon nc-box-2"></i>
                    View Inventory
                </button>
                <button class="action-btn secondary" onclick="generateInventoryReport()">
                    <i class="nc-icon nc-chart-bar-32"></i>
                    Generate Report
                </button>
            </div>
        </div>
    @endif
</div>

<style>
/* Stock Alerts Container */
.stock-alerts {
    font-family: 'Roboto', sans-serif;
    color: #2c3e50;
}

/* Summary Cards */
.alerts-summary {
    margin-bottom: 2rem;
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

.summary-card.critical {
    border-left: 4px solid #dc3545;
}

.summary-card.warning {
    border-left: 4px solid #ffc107;
}

.summary-card.info {
    border-left: 4px solid #17a2b8;
}

.summary-card.total {
    border-left: 4px solid #667eea;
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

.summary-card.critical .summary-icon {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.summary-card.warning .summary-icon {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.summary-card.info .summary-icon {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.summary-card.total .summary-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

/* Section Headers */
.alert-section {
    margin-bottom: 2rem;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding: 1rem 1.5rem;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.section-header.critical {
    border-left: 4px solid #dc3545;
}

.section-header.warning {
    border-left: 4px solid #ffc107;
}

.section-header.info {
    border-left: 4px solid #17a2b8;
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

.section-count {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Alerts Grid */
.alerts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1rem;
}

/* Alert Cards */
.alert-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.alert-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.alert-card.critical {
    border-left: 4px solid #dc3545;
}

.alert-card.warning {
    border-left: 4px solid #ffc107;
}

.alert-card.info {
    border-left: 4px solid #17a2b8;
}

.alert-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
}

.alert-card.critical .alert-icon {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.alert-card.warning .alert-icon {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.alert-card.info .alert-icon {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.priority-badge.critical {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.priority-badge.warning {
    background: rgba(255, 193, 7, 0.1);
    color: #e0a800;
}

.priority-badge.info {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.alert-body {
    margin-bottom: 1rem;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0 1rem 0;
    color: #2c3e50;
}

.stock-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stock-level {
    text-align: center;
    padding: 0.75rem;
    background: rgba(248, 249, 250, 0.8);
    border-radius: 8px;
}

.current-stock, .minimum-stock {
    display: block;
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
}

.stock-label {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.stock-progress {
    margin-bottom: 1rem;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-fill.critical {
    background: linear-gradient(90deg, #dc3545 0%, #c82333 100%);
}

.progress-fill.warning {
    background: linear-gradient(90deg, #ffc107 0%, #e0a800 100%);
}

.progress-fill.info {
    background: linear-gradient(90deg, #17a2b8 0%, #138496 100%);
}

.progress-text {
    font-size: 0.8rem;
    color: #6c757d;
}

.alert-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.action-btn.secondary {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

.action-btn.secondary:hover {
    background: rgba(102, 126, 234, 0.15);
    transform: translateY(-1px);
}

/* Quick Actions Section */
.quick-actions-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
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

/* No Alerts State */
.no-alerts-state {
    text-align: center;
    padding: 3rem 1rem;
}

.no-alerts-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin: 0 auto 1.5rem;
}

.no-alerts-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.no-alerts-message {
    color: #6c757d;
    margin-bottom: 2rem;
}

.no-alerts-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .alerts-grid {
        grid-template-columns: 1fr;
    }
    
    .stock-info {
        grid-template-columns: 1fr;
    }
    
    .alert-actions {
        flex-direction: column;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
    
    .no-alerts-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<script>
// Stock Alerts JavaScript Functions
function reorderProduct(productId) {
    if (productId) {
        // Redirect to reorder page or open reorder modal
        window.open(`/manufacturer/inventory/reorder/${productId}`, '_blank');
    } else {
        alert('Product ID not available');
    }
}

function viewProductDetails(productId) {
    if (productId) {
        // Open product details modal or redirect
        window.open(`/manufacturer/inventory/product/${productId}`, '_blank');
    } else {
        alert('Product ID not available');
    }
}

function reorderAllCritical() {
    if (confirm('Create reorder requests for all critical stock items?')) {
        // Implement bulk reorder functionality
        alert('Bulk reorder functionality will be implemented here');
    }
}

function generateReorderReport() {
    // Implement report generation
    alert('Reorder report generation will be implemented here');
}

function updateStockLevels() {
    // Redirect to inventory management
    window.location.href = '/manufacturer/inventory';
}

function viewInventory() {
    // Redirect to inventory page
    window.location.href = '/manufacturer/inventory';
}

function generateInventoryReport() {
    // Open inventory report modal
    openInventoryReportModal();
}
</script> 