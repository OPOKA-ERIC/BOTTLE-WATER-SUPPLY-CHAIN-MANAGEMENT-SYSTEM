@extends('layouts.app', ['activePage' => 'inventory', 'title' => 'Inventory Management'])

@section('content')
<div class="content">
    <div class="container-fluid">
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
                            <button class="quick-action-btn">
                                <div class="action-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Inventory Report</span>
                                    <span class="action-subtitle">Generate reports</span>
                                </div>
                            </button>
                            <button class="quick-action-btn">
                                <div class="action-icon">
                                    <i class="nc-icon nc-bell-55"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Stock Alerts</span>
                                    <span class="action-subtitle">Manage notifications</span>
                                </div>
                            </button>
                            <button class="quick-action-btn">
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
                                            <tr>
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
                                                        <button class="action-btn primary" data-toggle="modal" data-target="#updateInventoryModal{{ $item->id }}" title="Update Stock">
                                                            <i class="nc-icon nc-settings-gear-65"></i>
                                                            <span>Update</span>
                                                        </button>
                                                        <button class="action-btn secondary" title="View History">
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
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product">Product</label>
                                <select class="form-control" id="product" required>
                                    <option value="">Select Product</option>
                                    <option value="1">Bottled Water 500ml</option>
                                    <option value="2">Bottled Water 1L</option>
                                    <option value="3">Bottled Water 2L</option>
                                    <option value="4">Plastic Bottles</option>
                                    <option value="5">Bottle Caps</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_stock">Current Stock</label>
                                <input type="number" class="form-control" id="current_stock" placeholder="Enter current stock" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="minimum_stock">Minimum Stock Level</label>
                                <input type="number" class="form-control" id="minimum_stock" placeholder="Enter minimum stock" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit">Unit</label>
                                <select class="form-control" id="unit" required>
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
                        <textarea class="form-control" id="notes" rows="3" placeholder="Additional notes about this inventory item"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Item</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Inventory Modals -->
@if(isset($inventory) && $inventory->count() > 0)
    @foreach($inventory as $item)
    <div class="modal fade" id="updateInventoryModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="updateInventoryModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateInventoryModalLabel{{ $item->id }}">Update {{ $item->product->name ?? 'Product' }} Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="current_stock_{{ $item->id }}">Current Stock</label>
                            <input type="number" class="form-control" id="current_stock_{{ $item->id }}" value="{{ $item->current_stock }}" required>
                        </div>
                        <div class="form-group">
                            <label for="minimum_stock_{{ $item->id }}">Minimum Stock Level</label>
                            <input type="number" class="form-control" id="minimum_stock_{{ $item->id }}" value="{{ $item->minimum_stock }}" required>
                        </div>
                        <div class="form-group">
                            <label for="notes_{{ $item->id }}">Update Notes</label>
                            <textarea class="form-control" id="notes_{{ $item->id }}" rows="3" placeholder="Reason for update"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Update Stock</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif

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
</style>
@endsection 