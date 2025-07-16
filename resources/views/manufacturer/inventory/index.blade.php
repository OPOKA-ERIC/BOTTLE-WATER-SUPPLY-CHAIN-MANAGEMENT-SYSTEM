@extends('layouts.app', ['activePage' => 'inventory', 'title' => 'Inventory Management'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Inventory Management</h1>
                        <p class="welcome-subtitle">Monitor stock levels, track materials, and ensure optimal inventory for production</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $inventory->count() ?? 0 }}</h3>
                        <p class="stats-label">Total Products</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>In inventory</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-check-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $inventory->where('current_stock', '>', 'minimum_stock')->count() ?? 0 }}</h3>
                        <p class="stats-label">In Stock</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Well stocked</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-alert-circle-i"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $inventory->where('current_stock', '<=', 'minimum_stock')->count() ?? 0 }}</h3>
                        <p class="stats-label">Low Stock</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Needs attention</span>
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
                        <h3 class="stats-number">{{ number_format($inventory->sum('current_stock') ?? 0) }}</h3>
                        <p class="stats-label">Total Units</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Available stock</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Quick Actions</h4>
                            <p class="card-subtitle">Common inventory management tasks</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <button class="quick-action-btn" data-toggle="modal" data-target="#addInventoryModal">
                                <div class="action-icon">
                                    <i class="nc-icon nc-simple-add"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Add New Product</span>
                                    <span class="action-subtitle">Add to inventory</span>
                                </div>
                            </button>
                            <button class="quick-action-btn" onclick="openInventoryReportModal()">
                                <div class="action-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Inventory Report</span>
                                    <span class="action-subtitle">Generate reports</span>
                                </div>
                            </button>
                            <button class="quick-action-btn" onclick="openStockAlertsModal()">
                                <div class="action-icon">
                                    <i class="nc-icon nc-bell-55"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Stock Alerts</span>
                                    <span class="action-subtitle">View alerts</span>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="row">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Inventory Items</h4>
                            <p class="card-subtitle">Manage and monitor your production inventory</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($inventory) && $inventory->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Current Stock</th>
                                            <th>Minimum Stock</th>
                                            <th>Stock Level</th>
                                            <th>Status</th>
                                            <th>Last Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inventory as $item)
                                            <tr data-inventory-id="{{ $item->id }}">
                                                <td><span class="product-name">{{ $item->product->name ?? 'N/A' }}</span></td>
                                                <td><span class="current-stock">{{ number_format($item->current_stock) }}</span></td>
                                                <td><span class="minimum-stock">{{ number_format($item->minimum_stock) }}</span></td>
                                                <td>
                                                    <div class="stock-level-container">
                                                        <div class="stock-level-bar">
                                                            @php
                                                                $percentage = $item->minimum_stock > 0 ? min(100, ($item->current_stock / $item->minimum_stock) * 100) : 0;
                                                            @endphp
                                                            <div class="stock-level-fill" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                        <span class="stock-level-text">{{ number_format($percentage, 0) }}%</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($item->current_stock <= $item->minimum_stock)
                                                        <span class="status-badge status-low">Low Stock</span>
                                                    @elseif($item->current_stock <= $item->minimum_stock * 1.5)
                                                        <span class="status-badge status-warning">Moderate</span>
                                                    @else
                                                        <span class="status-badge status-good">In Stock</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->updated_at->format('M d, Y H:i') }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="action-btn primary update-stock-btn" 
                                                                data-inventory-id="{{ $item->id }}" 
                                                                data-current-stock="{{ $item->current_stock }}"
                                                                data-minimum-stock="{{ $item->minimum_stock }}"
                                                                data-product-name="{{ $item->product->name ?? 'Product' }}"
                                                                title="Update Stock">
                                                            <i class="nc-icon nc-settings-gear-65"></i>
                                                            <span>Update</span>
                                                        </button>
                                                        <button class="action-btn secondary view-history-btn" 
                                                                data-inventory-id="{{ $item->id }}"
                                                                data-product-name="{{ $item->product->name ?? 'Product' }}"
                                                                title="View History">
                                                            <i class="nc-icon nc-zoom-split-in"></i>
                                                            <span>History</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="pagination-container">
                                {{ $inventory->links() }}
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <h4 class="empty-title">No Inventory Found</h4>
                                <p class="empty-subtitle">No inventory items have been added yet. Start by adding your first product to inventory.</p>
                                <button class="empty-action-btn" data-toggle="modal" data-target="#addInventoryModal">
                                    <i class="nc-icon nc-simple-add"></i>
                                    <span>Add First Item</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Inventory Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" role="dialog" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryModalLabel">Add New Inventory Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addInventoryForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_stock">Current Stock</label>
                                <input type="number" class="form-control" id="current_stock" name="current_stock" placeholder="Enter current stock" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="minimum_stock">Minimum Stock Level</label>
                                <input type="number" class="form-control" id="minimum_stock" name="minimum_stock" placeholder="Enter minimum stock" required min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <select class="form-control" id="unit" name="unit" required>
                                    <option value="">Select Unit</option>
                                    <option value="pieces">Pieces</option>
                                    <option value="boxes">Boxes</option>
                                    <option value="pallets">Pallets</option>
                                    <option value="liters">Liters</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes about this inventory item"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="addInventoryBtn" onclick="addInventory()">
                    <span class="btn-text">Add Item</span>
                    <span class="btn-loading d-none">
                        <i class="nc-icon nc-refresh-69 fa-spin"></i>
                        Adding...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Update Inventory Modal -->
<div class="modal fade" id="updateInventoryModal" tabindex="-1" role="dialog" aria-labelledby="updateInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateInventoryModalLabel">Update Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateInventoryForm">
                <div class="modal-body">
                    <input type="hidden" id="update_inventory_id" name="inventory_id">
                    
                    <div class="form-group">
                        <label for="update_current_stock">Current Stock</label>
                        <input type="number" class="form-control" id="update_current_stock" name="current_stock" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="update_minimum_stock">Minimum Stock Level</label>
                        <input type="number" class="form-control" id="update_minimum_stock" name="minimum_stock" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="update_notes">Notes (Optional)</label>
                        <textarea class="form-control" id="update_notes" name="notes" rows="3" placeholder="Add any notes about this stock update..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateInventoryBtn">
                        <span class="btn-text">Update Stock</span>
                        <span class="btn-loading d-none">
                            <i class="fa fa-spinner fa-spin"></i> Updating...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inventory History Modal -->
<div class="modal fade" id="inventoryHistoryModal" tabindex="-1" role="dialog" aria-labelledby="inventoryHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inventoryHistoryModalLabel">Inventory History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="inventoryHistoryContent">
                    <div class="text-center text-muted">
                        <i class="fa fa-spinner fa-spin fa-2x mb-3"></i>
                        <p>Loading inventory history...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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

<!-- Bulk Update Modal -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1" role="dialog" aria-labelledby="bulkUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkUpdateModalLabel">Bulk Update Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h6><i class="nc-icon nc-ruler-pencil"></i> Instructions</h6>
                    <p class="mb-2">To bulk update your inventory:</p>
                    <ol class="mb-0">
                        <li>Download the template CSV file with your current inventory data</li>
                        <li>Edit the stock values in the CSV file</li>
                        <li>Upload the updated CSV file</li>
                        <li>Review the results and confirm</li>
                    </ol>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-primary btn-block" onclick="downloadTemplate()">
                            <i class="nc-icon nc-cloud-download-93"></i>
                            Download Template
                        </button>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">
                            <i class="nc-icon nc-alert-circle-i"></i>
                            Template includes current inventory data
                        </small>
                    </div>
                </div>
                
                <form id="bulkUpdateForm">
                    <div class="form-group">
                        <label for="bulkUpdateFile">Upload Updated CSV File</label>
                        <input type="file" class="form-control" id="bulkUpdateFile" accept=".csv" required>
                        <small class="form-text text-muted">
                            <i class="nc-icon nc-info"></i>
                            File must be in CSV format. Maximum size: 2MB.
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        Process Bulk Update
                    </button>
                </form>
                
                <div id="bulkUpdateResult" class="mt-3"></div>
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

/* Table Styling */
.table {
    margin-bottom: 0;
}

.table th {
    border-top: none;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    border-top: 1px solid #f8f9fa;
    vertical-align: middle;
    padding: 15px 8px;
}

.product-name {
    font-weight: 500;
    color: #2c3e50;
}

.current-stock {
    font-weight: 600;
    color: #27ae60;
}

.minimum-stock {
    font-weight: 500;
    color: #7f8c8d;
}

/* Stock Level Bar */
.stock-level-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.stock-level-bar {
    flex: 1;
    height: 8px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.stock-level-fill {
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.stock-level-text {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    min-width: 35px;
}

/* Status Badges */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.status-good {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
    border: 1px solid rgba(39, 174, 96, 0.2);
}

.status-badge.status-warning {
    background: rgba(243, 156, 18, 0.1);
    color: #f39c12;
    border: 1px solid rgba(243, 156, 18, 0.2);
}

.status-badge.status-low {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.2);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.action-btn {
    padding: 6px 12px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.action-btn.secondary {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    border: 1px solid rgba(108, 117, 125, 0.2);
}

.action-btn.secondary:hover {
    background: rgba(108, 117, 125, 0.2);
    transform: translateY(-2px);
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
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

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.empty-subtitle {
    color: #7f8c8d;
    margin-bottom: 30px;
    font-size: 1rem;
}

.empty-action-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 auto;
}

.empty-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

/* Modal Styling */
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    border-bottom: none;
}

.modal-title {
    font-weight: 600;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
}

.modal-header .close:hover {
    opacity: 1;
}

.modal-body {
    padding: 30px;
}

.form-group label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #e9ecef;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 20px 30px;
}

.btn {
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-btn {
        justify-content: center;
    }
    
    .stock-level-container {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .stock-level-text {
        text-align: left;
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
    
    .quick-action-btn {
        padding: 15px;
    }
    
    .modal-dialog {
        margin: 10px;
    }
}

/* Inventory Report Styles */
.inventory-report {
    font-family: 'Roboto', sans-serif;
}

.inventory-report .report-header {
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 1rem;
}

.inventory-report .stat-card {
    transition: transform 0.2s ease;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.inventory-report .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.inventory-report .card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
    margin-bottom: 1rem;
}

.inventory-report .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 8px 8px 0 0;
    border: none;
    padding: 1rem;
}

.inventory-report .stock-level-item {
    padding: 0.5rem;
    border-radius: 4px;
    background: #f8f9fa;
    transition: background-color 0.2s ease;
}

.inventory-report .stock-level-item:hover {
    background: #e9ecef;
}

.inventory-report .product-item {
    padding: 0.5rem;
    border-radius: 4px;
    background: #f8f9fa;
    transition: background-color 0.2s ease;
}

.inventory-report .product-item:hover {
    background: #e9ecef;
}

.inventory-report .product-name {
    font-weight: 500;
    color: #495057;
}

.inventory-report .stock-amount {
    font-weight: 600;
    color: #28a745;
}

.inventory-report .table {
    margin-bottom: 0;
}

.inventory-report .table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background: #f8f9fa;
}

.inventory-report .table td {
    vertical-align: middle;
}

.inventory-report .badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.inventory-report .report-footer {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
}

/* Modal specific styles */
#inventoryReportModal .modal-dialog {
    max-width: 90%;
}

#inventoryReportModal .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

#inventoryReportModal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    border: none;
}

#inventoryReportModal .modal-body {
    max-height: 70vh;
    overflow-y: auto;
    padding: 2rem;
}

/* Loading animation */
.loading-spinner {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Stock Alerts Styles */
.stock-alerts {
    font-family: 'Roboto', sans-serif;
}

.stock-alerts .alerts-header {
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 1rem;
}

.stock-alerts .alert-summary {
    transition: transform 0.2s ease;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stock-alerts .alert-summary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.stock-alerts .alert {
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.stock-alerts .alert-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
}

.stock-alerts .alert-content {
    flex: 1;
}

.stock-alerts .alert-heading {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.stock-alerts .alert-message {
    color: #6c757d;
    margin-bottom: 1rem;
}

.stock-alerts .product-details {
    background: rgba(0,0,0,0.05);
    padding: 0.75rem;
    border-radius: 4px;
    font-size: 0.9rem;
    line-height: 1.4;
}

.stock-alerts .alert-actions {
    margin-top: 1rem;
}

.stock-alerts .quick-actions {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 2rem;
}

.stock-alerts .no-alerts {
    padding: 3rem 1rem;
}

/* Alert type specific styles */
.stock-alerts .alert-critical {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
}

.stock-alerts .alert-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
    color: #212529;
}

.stock-alerts .alert-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
}

.stock-alerts .alert-danger {
    background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
    color: white;
}

/* Modal specific styles for alerts */
#stockAlertsModal .modal-dialog {
    max-width: 90%;
}

#stockAlertsModal .modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

#stockAlertsModal .modal-header {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    border: none;
}

#stockAlertsModal .modal-body {
    max-height: 70vh;
    overflow-y: auto;
    padding: 2rem;
}

/* Button hover effects */
.stock-alerts .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stock-alerts .alert-summary {
        margin-bottom: 1rem;
    }
    
    .stock-alerts .quick-actions .btn {
        margin-bottom: 0.5rem;
    }
    
    #stockAlertsModal .modal-dialog {
        max-width: 95%;
        margin: 1rem;
    }
}

/* Alert Styles */
.alert {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.alert-info {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.alert-success {
    background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    color: white;
}

.alert-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

/* Bulk Update Modal Styles */
#bulkUpdateModal .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

#bulkUpdateModal .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
}

#bulkUpdateModal .modal-title {
    font-weight: 600;
}

#bulkUpdateModal .btn-outline-primary {
    border-color: #667eea;
    color: #667eea;
    transition: all 0.3s ease;
}

#bulkUpdateModal .btn-outline-primary:hover {
    background: #667eea;
    border-color: #667eea;
    color: white;
    transform: translateY(-2px);
}

#bulkUpdateModal .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

#bulkUpdateModal .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

/* Results Table Styles */
#bulkUpdateResult .table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

#bulkUpdateResult .table thead th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-weight: 600;
    padding: 12px;
}

#bulkUpdateResult .table tbody td {
    padding: 12px;
    border-bottom: 1px solid #f0f0f0;
}

#bulkUpdateResult .table tbody tr:hover {
    background-color: #f8f9fa;
}

/* File Upload Styles */
#bulkUpdateFile {
    border: 2px dashed #667eea;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

#bulkUpdateFile:hover {
    border-color: #764ba2;
    background-color: #f8f9fa;
}

/* Instructions Styles */
#bulkUpdateModal .alert-info ol {
    padding-left: 20px;
}

#bulkUpdateModal .alert-info li {
    margin-bottom: 5px;
    line-height: 1.4;
}
</style>
@endsection

@push('js')
<script>
// Global variables
let isAddingInventory = false;

// Initialize when document is ready
$(document).ready(function() {
    console.log('Document ready, initializing inventory management page');
    
    // Check if CSRF token is available
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log('CSRF token available:', !!csrfToken);
    
    // Check if products are loaded
    const productSelect = $('#product_id');
    console.log('Products loaded:', productSelect.find('option').length - 1); // -1 for the default option
    
    console.log('Inventory management page initialized successfully');
});

// Handle modal events
$('#addInventoryModal').on('show.bs.modal', function() {
    console.log('Add inventory modal is showing');
});

$('#addInventoryModal').on('shown.bs.modal', function() {
    console.log('Add inventory modal is shown');
    
    // Debug form field values
    console.log('Form field values:');
    console.log('Product ID:', $('#product_id').val());
    console.log('Current Stock:', $('#current_stock').val());
    console.log('Minimum Stock:', $('#minimum_stock').val());
    console.log('Unit:', $('#unit').val());
    console.log('Notes:', $('#notes').val());
    
    // Check if form has CSRF token
    const csrfInput = $('#addInventoryForm input[name="_token"]');
    console.log('CSRF input exists:', csrfInput.length > 0);
    if (csrfInput.length > 0) {
        console.log('CSRF token value:', csrfInput.val());
    }
});

$('#addInventoryModal').on('hidden.bs.modal', function() {
    console.log('Add inventory modal is hidden');
    const form = $('#addInventoryForm')[0];
    form.reset();
    
    // Reset button state
    const btn = $('#addInventoryBtn');
    btn.find('.btn-text').removeClass('d-none');
    btn.find('.btn-loading').addClass('d-none');
    btn.prop('disabled', false);
    isAddingInventory = false;
});

// Add new inventory item
function addInventory() {
    console.log('addInventory function called');
    
    if (isAddingInventory) {
        console.log('Already adding inventory, returning');
        return;
    }
    
    const form = $('#addInventoryForm')[0];
    const formData = new FormData(form);
    
    // Debug: Log form data
    console.log('Form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Validate form
    if (!form.checkValidity()) {
        console.log('Form validation failed');
        form.reportValidity();
        return;
    }
    
    console.log('Form validation passed, proceeding with AJAX request');
    
    isAddingInventory = true;
    const btn = $('#addInventoryBtn');
    const btnText = btn.find('.btn-text');
    const btnLoading = btn.find('.btn-loading');
    
    // Show loading state
    btnText.addClass('d-none');
    btnLoading.removeClass('d-none');
    btn.prop('disabled', true);
    
    console.log('Making AJAX request to:', '{{ route("manufacturer.inventory.store") }}');
    
    $.ajax({
        url: '{{ route("manufacturer.inventory.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('AJAX success response:', response);
            if (response.success) {
                showNotification('success', 'Success', response.message || 'Inventory item added successfully');
                $('#addInventoryModal').modal('hide');
                form.reset();
                // Refresh the page to show the new item
                location.reload();
            } else {
                showNotification('danger', 'Error', response.message || 'Failed to add inventory item');
                console.error('Failed to add inventory item:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX error:', {xhr: xhr, status: status, error: error});
            console.log('Response text:', xhr.responseText);
            console.log('Response status:', xhr.status);
            console.log('Response status text:', xhr.statusText);
            
            let errorMessage = 'Failed to add inventory item';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            } else if (xhr.status === 404) {
                errorMessage = 'Route not found. Please refresh the page.';
            }
            
            showNotification('danger', 'Error', errorMessage);
            console.error('AJAX Error:', xhr.status, xhr.statusText, xhr.responseText);
        },
        complete: function() {
            console.log('AJAX request completed');
            // Reset button state
            btnText.removeClass('d-none');
            btnLoading.addClass('d-none');
            btn.prop('disabled', false);
            isAddingInventory = false;
        }
    });
}

// Helper function to show notifications
function showNotification(type, title, message) {
    $.notify({
        icon: type === 'success' ? 'nc-icon nc-check-2' : 'nc-icon nc-alert-circle-i',
        title: title,
        message: message
    }, {
        type: type,
        timer: 5000,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
}

// Update Stock Button Click
$(document).on('click', '.update-stock-btn', function(e) {
    e.preventDefault();
    
    var inventoryId = $(this).data('inventory-id');
    var currentStock = $(this).data('current-stock');
    var minimumStock = $(this).data('minimum-stock');
    var productName = $(this).data('product-name');
    
    // Populate the modal
    $('#update_inventory_id').val(inventoryId);
    $('#update_current_stock').val(currentStock);
    $('#update_minimum_stock').val(minimumStock);
    $('#updateInventoryModalLabel').text('Update ' + productName + ' Stock');
    $('#update_notes').val('');
    
    // Show the modal
    $('#updateInventoryModal').modal('show');
});

// Update Inventory Form Submission
$(document).on('click', '#updateInventoryBtn', function(e) {
    e.preventDefault();
    
    var form = $('#updateInventoryForm');
    var modal = $('#updateInventoryModal');
    var btn = $(this);
    
    // Basic form validation
    if (!form[0].checkValidity()) {
        form[0].reportValidity();
        return;
    }
    
    btn.prop('disabled', true).text('Updating...');
    
    $.ajax({
        url: '{{ route("manufacturer.inventory.update", ["id" => ":id"]) }}'.replace(':id', $('#update_inventory_id').val()),
        type: 'PUT',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                modal.modal('hide');
                // Update the table row in real-time
                updateTableRow(response.inventory);
                showNotification('success', 'Stock updated successfully!');
            } else {
                showNotification('error', response.message || 'Failed to update stock');
            }
        },
        error: function(xhr, status, error) {
            if (xhr.status === 422) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = 'Validation errors:\n';
                for (var field in errors) {
                    errorMessage += field + ': ' + errors[field][0] + '\n';
                }
                showNotification('error', errorMessage);
            } else {
                showNotification('error', 'Failed to update stock. Please try again.');
            }
        },
        complete: function() {
            btn.prop('disabled', false).text('Update Stock');
        }
    });
});

// View History Button Click
$(document).on('click', '.view-history-btn', function(e) {
    e.preventDefault();
    
    var inventoryId = $(this).data('inventory-id');
    var productName = $(this).data('product-name');
    
    // Update modal title
    $('#inventoryHistoryModalLabel').text(productName + ' - Inventory History');
    
    // Show the modal
    $('#inventoryHistoryModal').modal('show');
    
    $.ajax({
        url: '/manufacturer/inventory/' + inventoryId + '/history',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                // Format the history data for display
                var historyHtml = formatInventoryHistory(response.inventory, response.history);
                $('#inventoryHistoryContent').html(historyHtml);
            } else {
                $('#inventoryHistoryContent').html('<div class="text-danger">' + (response.message || 'Failed to load history') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            $('#inventoryHistoryContent').html('<div class="text-danger">Failed to load history. Please try again.</div>');
        }
    });
});

// Function to format inventory history for display
function formatInventoryHistory(inventory, history) {
    var html = '<div class="inventory-history">';
    
    // Current Status Section
    html += '<div class="history-section mb-4">';
    html += '<h6 class="text-primary mb-3"><i class="fa fa-info-circle"></i> Current Status</h6>';
    html += '<div class="row">';
    html += '<div class="col-md-6"><strong>Current Stock:</strong> ' + inventory.current_stock.toLocaleString() + ' ' + (inventory.unit || 'units') + '</div>';
    html += '<div class="col-md-6"><strong>Minimum Stock:</strong> ' + inventory.minimum_stock.toLocaleString() + ' ' + (inventory.unit || 'units') + '</div>';
    html += '<div class="col-md-6"><strong>Unit:</strong> ' + (inventory.unit || 'units') + '</div>';
    html += '<div class="col-md-6"><strong>Last Updated:</strong> ' + new Date(inventory.updated_at).toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }) + '</div>';
    html += '</div>';
    html += '</div>';
    
    // Notes Section
    if (inventory.notes) {
        html += '<div class="history-section mb-4">';
        html += '<h6 class="text-info mb-3"><i class="fa fa-sticky-note"></i> Notes</h6>';
        html += '<p class="mb-0">' + inventory.notes + '</p>';
        html += '</div>';
    }
    
    // Stock Analysis Section
    var stockLevel = inventory.minimum_stock > 0 ? Math.min(100, (inventory.current_stock / inventory.minimum_stock) * 100) : 0;
    var statusClass = stockLevel <= 100 ? 'text-danger' : stockLevel <= 150 ? 'text-warning' : 'text-success';
    var statusText = stockLevel <= 100 ? 'Low Stock' : stockLevel <= 150 ? 'Moderate Stock' : 'Good Stock';
    var statusIcon = stockLevel <= 100 ? '⚠️' : stockLevel <= 150 ? '⚠️' : '✅';
    
    html += '<div class="history-section mb-4">';
    html += '<h6 class="text-success mb-3"><i class="fa fa-chart-line"></i> Stock Analysis</h6>';
    html += '<div class="row">';
    html += '<div class="col-md-6"><strong>Stock Level:</strong> ' + stockLevel.toFixed(1) + '%</div>';
    html += '<div class="col-md-6"><strong>Status:</strong> <span class="' + statusClass + '">' + statusIcon + ' ' + statusText + '</span></div>';
    html += '</div>';
    html += '</div>';
    
    // History Timeline Section
    if (history && history.length > 0) {
        html += '<div class="history-section">';
        html += '<h6 class="text-secondary mb-3"><i class="fa fa-history"></i> Update History</h6>';
        html += '<div class="timeline">';
        
        history.forEach(function(entry, index) {
            var isLatest = index === 0;
            var badgeClass = isLatest ? 'badge-primary' : 'badge-secondary';
            var borderClass = isLatest ? 'border-primary' : 'border-light';
            
            html += '<div class="timeline-item ' + borderClass + ' mb-3 p-3 border-left">';
            html += '<div class="d-flex justify-content-between align-items-start">';
            html += '<div>';
            html += '<span class="badge ' + badgeClass + ' mb-2">' + (isLatest ? 'Latest' : 'Previous') + '</span>';
            html += '<p class="mb-1"><strong>Stock Updated:</strong> ' + entry.current_stock.toLocaleString() + ' ' + (inventory.unit || 'units') + '</p>';
            if (entry.minimum_stock !== inventory.minimum_stock) {
                html += '<p class="mb-1"><strong>Min Stock:</strong> ' + entry.minimum_stock.toLocaleString() + ' ' + (inventory.unit || 'units') + '</p>';
            }
            if (entry.notes) {
                html += '<p class="mb-1"><strong>Notes:</strong> ' + entry.notes + '</p>';
            }
            html += '</div>';
            html += '<small class="text-muted">' + new Date(entry.updated_at).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }) + '</small>';
            html += '</div>';
            html += '</div>';
        });
        
        html += '</div>';
        html += '</div>';
    } else {
        html += '<div class="history-section">';
        html += '<h6 class="text-secondary mb-3"><i class="fa fa-history"></i> Update History</h6>';
        html += '<p class="text-muted">No update history available for this inventory item.</p>';
        html += '</div>';
    }
    
    html += '</div>';
    return html;
}

// Function to update table row in real-time
function updateTableRow(inventory) {
    var row = $('tr[data-inventory-id="' + inventory.id + '"]');
    if (row.length === 0) {
        // If row doesn't exist, reload the page
        location.reload();
        return;
    }
    
    // Update current stock
    row.find('.current-stock').text(inventory.current_stock.toLocaleString());
    
    // Update minimum stock
    row.find('.minimum-stock').text(inventory.minimum_stock.toLocaleString());
    
    // Update stock level percentage
    var percentage = inventory.minimum_stock > 0 ? Math.min(100, (inventory.current_stock / inventory.minimum_stock) * 100) : 0;
    row.find('.stock-level-fill').css('width', percentage + '%');
    row.find('.stock-level-text').text(percentage.toFixed(0) + '%');
    
    // Update status badge
    var statusBadge = row.find('.status-badge');
    statusBadge.removeClass('status-low status-warning status-good');
    
    if (inventory.current_stock <= inventory.minimum_stock) {
        statusBadge.addClass('status-low').text('Low Stock');
    } else if (inventory.current_stock <= inventory.minimum_stock * 1.5) {
        statusBadge.addClass('status-warning').text('Moderate');
    } else {
        statusBadge.addClass('status-good').text('In Stock');
    }
    
    // Update button data attributes
    var updateBtn = row.find('.update-stock-btn');
    updateBtn.data('current-stock', inventory.current_stock);
    updateBtn.data('minimum-stock', inventory.minimum_stock);
}

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

// Download report function
function downloadReport() {
    console.log('Downloading report...');
    // For now, just show a message. In a real implementation, this would generate and download a PDF
    showNotification('info', 'Download', 'PDF download feature will be implemented soon. For now, you can print this page using Ctrl+P.');
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
    showNotification('info', 'Action', 'Action "' + action + '" for ' + productName + ' will be implemented soon.');
}

function generateRestockList() {
    console.log('Generating restock list...');
    showNotification('info', 'Restock List', 'Restock list generation will be implemented soon.');
}

function exportAlerts() {
    console.log('Exporting alerts...');
    showNotification('info', 'Export', 'Alert export feature will be implemented soon.');
}

function scheduleAlerts() {
    console.log('Scheduling alerts...');
    showNotification('info', 'Schedule', 'Alert scheduling feature will be implemented soon.');
}

function refreshAlerts() {
    console.log('Refreshing alerts...');
    openStockAlertsModal();
}

// ===== BULK UPDATE FUNCTIONS =====

function openBulkUpdateModal() {
    console.log('Opening bulk update modal...');
    $('#bulkUpdateModal').modal('show');
    $('#bulkUpdateResult').html('');
    $('#bulkUpdateFile').val('');
}

// Download template function
function downloadTemplate() {
    console.log('Downloading template...');
    window.location.href = '{{ route("manufacturer.inventory.template") }}';
}

// Handle bulk update form submission
$(document).on('submit', '#bulkUpdateForm', function(e) {
    e.preventDefault();
    
    var fileInput = $('#bulkUpdateFile')[0];
    var resultDiv = $('#bulkUpdateResult');
    
    if (!fileInput.files[0]) {
        resultDiv.html('<div class="alert alert-danger">Please select a CSV file to upload.</div>');
        return;
    }
    
    var formData = new FormData();
    formData.append('csv_file', fileInput.files[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    
    // Show loading state
    resultDiv.html('<div class="text-center text-muted"><i class="nc-icon nc-refresh-69 fa-spin fa-2x mb-3"></i><p>Processing bulk update...</p></div>');
    
    $.ajax({
        url: '{{ route("manufacturer.inventory.bulk-update") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Bulk update response:', response);
            if (response.success) {
                var resultHtml = '<div class="alert alert-success">';
                resultHtml += '<h6><i class="nc-icon nc-check-2"></i> ' + response.message + '</h6>';
                
                if (response.results) {
                    resultHtml += '<div class="mt-3">';
                    resultHtml += '<p><strong>Summary:</strong></p>';
                    resultHtml += '<ul class="list-unstyled">';
                    resultHtml += '<li><i class="nc-icon nc-check-2 text-success"></i> Successfully updated: ' + response.results.success + ' items</li>';
                    resultHtml += '<li><i class="nc-icon nc-alert-circle-i text-danger"></i> Failed updates: ' + response.results.failed + ' items</li>';
                    resultHtml += '</ul>';
                    
                    if (response.results.errors && response.results.errors.length > 0) {
                        resultHtml += '<div class="mt-3">';
                        resultHtml += '<p><strong>Errors:</strong></p>';
                        resultHtml += '<div class="alert alert-warning">';
                        resultHtml += '<ul class="list-unstyled mb-0">';
                        response.results.errors.forEach(function(error) {
                            resultHtml += '<li><i class="nc-icon nc-alert-circle-i"></i> ' + error + '</li>';
                        });
                        resultHtml += '</ul>';
                        resultHtml += '</div>';
                        resultHtml += '</div>';
                    }
                    
                    if (response.results.updated_items && response.results.updated_items.length > 0) {
                        resultHtml += '<div class="mt-3">';
                        resultHtml += '<p><strong>Updated Items:</strong></p>';
                        resultHtml += '<div class="table-responsive">';
                        resultHtml += '<table class="table table-sm">';
                        resultHtml += '<thead><tr><th>Product</th><th>Old Stock</th><th>New Stock</th><th>Old Min</th><th>New Min</th></tr></thead>';
                        resultHtml += '<tbody>';
                        response.results.updated_items.forEach(function(item) {
                            resultHtml += '<tr>';
                            resultHtml += '<td>' + item.product_name + '</td>';
                            resultHtml += '<td>' + item.old_stock.toLocaleString() + '</td>';
                            resultHtml += '<td><span class="text-success">' + item.new_stock.toLocaleString() + '</span></td>';
                            resultHtml += '<td>' + item.old_min_stock.toLocaleString() + '</td>';
                            resultHtml += '<td><span class="text-success">' + item.new_min_stock.toLocaleString() + '</span></td>';
                            resultHtml += '</tr>';
                        });
                        resultHtml += '</tbody>';
                        resultHtml += '</table>';
                        resultHtml += '</div>';
                        resultHtml += '</div>';
                    }
                    
                    resultHtml += '</div>';
                }
                
                resultHtml += '</div>';
                resultDiv.html(resultHtml);
                
                // Show success notification
                showNotification('success', 'Bulk Update Complete', response.message);
                
                // Refresh the page after successful update to show changes
                setTimeout(function() {
                    location.reload();
                }, 3000);
                
            } else {
                resultDiv.html('<div class="alert alert-danger"><i class="nc-icon nc-alert-circle-i"></i> ' + (response.message || 'Failed to process bulk update') + '</div>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Bulk update error:', xhr.status, xhr.statusText);
            let errorMessage = 'Failed to process bulk update';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 422) {
                errorMessage = 'Invalid file format. Please check your CSV file.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            resultDiv.html('<div class="alert alert-danger"><i class="nc-icon nc-alert-circle-i"></i> ' + errorMessage + '</div>');
        }
    });
});

// Reset bulk update modal when closed
$('#bulkUpdateModal').on('hidden.bs.modal', function() {
    $('#bulkUpdateForm')[0].reset();
    $('#bulkUpdateResult').html('');
});
</script>
@endpush 