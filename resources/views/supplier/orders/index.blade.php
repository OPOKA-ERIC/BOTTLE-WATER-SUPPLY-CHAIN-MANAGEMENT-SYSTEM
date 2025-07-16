@extends('layouts.app', ['activePage' => 'orders', 'title' => 'Orders Management'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Orders Management</h1>
                        <p class="welcome-subtitle">Track incoming orders from manufacturers, monitor order status, and manage fulfillment</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $orders->count() }}</h3>
                        <p class="stats-label">Total Orders</p>
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
                        <i class="nc-icon nc-time-alarm"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $orders->where('status', 'pending')->count() }}</h3>
                        <p class="stats-label">Pending</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Awaiting fulfillment</span>
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
                        <h3 class="stats-number">{{ $orders->where('status', 'completed')->count() }}</h3>
                        <p class="stats-label">Completed</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Successfully fulfilled</span>
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
                        <h3 class="stats-number">{{ $orders->where('status', 'processing')->count() }}</h3>
                        <p class="stats-label">Processing</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>In progress</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
    <div class="row">
        <div class="col-md-12">
                <div class="content-card">
                <div class="card-header">
                        <div class="header-content">
                    <h4 class="card-title">Supplier Orders</h4>
                            <p class="card-subtitle">Manage incoming orders from manufacturers and track fulfillment status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                </div>
                <div class="card-body">
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Manufacturer</th>
                                        <th>Materials</th>
                                        <th>Total Quantity</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                                <td>
                                                    <div class="order-info">
                                                        <span class="order-id">#{{ $order->id }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="manufacturer-info">
                                                        <span class="manufacturer-name">{{ $order->manufacturer->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="materials-list">
                                                @foreach($order->rawMaterials as $material)
                                                            <span class="material-badge">
                                                                <i class="nc-icon nc-box-2"></i>
                                                                {{ $material->name }} ({{ $material->pivot->quantity }})
                                                            </span>
                                                @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="quantity-badge quantity-{{ $order->rawMaterials->sum('pivot.quantity') > 100 ? 'high' : ($order->rawMaterials->sum('pivot.quantity') > 50 ? 'medium' : 'low') }}">
                                                        {{ $order->rawMaterials->sum('pivot.quantity') }}
                                                    </span>
                                            </td>
                                            <td>
                                                    <span class="status-badge status-{{ $order->status }}">
                                                        <i class="nc-icon {{ $order->status === 'pending' ? 'nc-time-alarm' : ($order->status === 'completed' ? 'nc-check-2' : 'nc-settings-gear-65') }}"></i>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                                <td>
                                                    <span class="date-label">{{ $order->created_at->format('M d, Y') }}</span>
                                                </td>
                                            <td>
                                                    <a href="{{ route('supplier.orders.show', $order->id) }}" class="action-btn primary">
                                                        <i class="nc-icon nc-zoom-split-in"></i>
                                                        <span>View</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                            <div class="pagination-section">
                            {{ $orders->links() }}
                        </div>
                    @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-cart-simple"></i>
                                </div>
                                <h5 class="empty-title">No Orders Found</h5>
                                <p class="empty-subtitle">No orders have been placed by manufacturers yet</p>
                                <div class="empty-actions">
                                    <button class="action-btn primary">
                                        <i class="nc-icon nc-refresh-69"></i>
                                        <span>Refresh Orders</span>
                                    </button>
                                </div>
                        </div>
                    @endif
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

.order-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.order-id {
    font-weight: 600;
    color: #1976d2;
    font-size: 1rem;
}

.manufacturer-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.manufacturer-name {
    font-weight: 600;
    color: #333;
}

.materials-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    max-width: 300px;
}

.material-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    white-space: nowrap;
}

.material-badge i {
    font-size: 10px;
}

.quantity-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
    min-width: 60px;
    justify-content: center;
}

.quantity-high {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.quantity-medium {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.quantity-low {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.date-label {
    font-weight: 500;
    color: #666;
    font-size: 0.9rem;
}

/* Status Badges */
.status-badge {
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

.status-pending {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-processing {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

.status-completed {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-badge i {
    font-size: 12px;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.action-btn i {
    font-size: 14px;
}

/* Pagination Section */
.pagination-section {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    gap: 5px;
}

.page-link {
    padding: 8px 12px;
    border: 1px solid rgba(25, 118, 210, 0.2);
    background: rgba(255, 255, 255, 0.8);
    color: #1976d2;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: rgba(25, 118, 210, 0.1);
    border-color: #1976d2;
    color: #1976d2;
    transform: translateY(-2px);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
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
    margin: 0 0 30px 0;
}

.empty-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
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
    
    .materials-list {
        max-width: 200px;
    }
    
    .material-badge {
        font-size: 0.7rem;
        padding: 3px 6px;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endsection 