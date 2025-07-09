@extends('layouts.app', ['activePage' => 'orders', 'title' => 'Order Details'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Order Details</h1>
                        <p class="welcome-subtitle">View and manage purchase order details</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="row">
            <div class="col-md-8">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Order #{{ $order->order_number }}</h4>
                            <p class="card-subtitle">Purchase order details and items</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Order Status -->
                        <div class="order-status mb-4">
                            <div class="status-info">
                                <h5>Order Status</h5>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="status-actions">
                                <form action="{{ route('supplier.orders.status', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-control form-control-sm d-inline-block w-auto">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                                        <i class="nc-icon nc-settings-gear-65"></i>
                                        Update Status
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="order-items">
                            <h5>Order Items</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="material-info">
                                                        <span class="material-name">{{ $item->rawMaterial->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="material-description">
                                                        {{ Str::limit($item->rawMaterial->description ?? 'No description', 50) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="quantity-badge">
                                                        {{ $item->quantity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="price-label">${{ number_format($item->unit_price, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="total-label">${{ number_format($item->quantity * $item->unit_price, 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Order Summary</h4>
                            <p class="card-subtitle">Order overview and totals</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="summary-item">
                            <span class="summary-label">Order Number</span>
                            <span class="summary-value">#{{ $order->order_number }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Manufacturer</span>
                            <span class="summary-value">{{ $order->manufacturer->name ?? 'N/A' }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Order Date</span>
                            <span class="summary-value">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Last Updated</span>
                            <span class="summary-value">{{ $order->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Total Items</span>
                            <span class="summary-value">{{ $order->items->count() }}</span>
                        </div>
                        <div class="summary-item total">
                            <span class="summary-label">Total Amount</span>
                            <span class="summary-value">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="content-card mt-4">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Quick Actions</h4>
                            <p class="card-subtitle">Manage this order</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            <a href="{{ route('supplier.chats.index') }}" class="action-btn primary">
                                <i class="nc-icon nc-chat-33"></i>
                                <span>Contact Manufacturer</span>
                            </a>
                            <a href="{{ route('supplier.orders.index') }}" class="action-btn secondary">
                                <i class="nc-icon nc-minimal-left"></i>
                                <span>Back to Orders</span>
                            </a>
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
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: none;
}

.header-content {
    flex: 1;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 5px 0;
    color: white;
}

.card-subtitle {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
    color: white;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-icon i {
    font-size: 24px;
    color: white;
}

.card-body {
    padding: 30px;
}

/* Order Status */
.order-status {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 30px;
}

.status-info h5 {
    margin: 0 0 10px 0;
    color: #333;
    font-weight: 600;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-processing {
    background: #cce5ff;
    color: #004085;
}

.status-shipped {
    background: #d1ecf1;
    color: #0c5460;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.status-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Table Styles */
.table {
    margin: 0;
}

.table th {
    border-top: none;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #333;
    padding: 15px 10px;
    background: #f8f9fa;
}

.table td {
    border-top: none;
    border-bottom: 1px solid #e9ecef;
    padding: 15px 10px;
    vertical-align: middle;
}

/* Material Info */
.material-info {
    display: flex;
    flex-direction: column;
}

.material-name {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.material-description {
    font-size: 0.85rem;
    color: #666;
    margin-top: 2px;
}

.quantity-badge {
    background: #e3f2fd;
    color: #1976d2;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.price-label,
.total-label {
    font-weight: 600;
    color: #333;
}

.total-label {
    color: #1976d2;
    font-size: 1.1rem;
}

/* Summary Items */
.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #e9ecef;
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-item.total {
    border-top: 2px solid #e9ecef;
    margin-top: 10px;
    padding-top: 15px;
    font-weight: 700;
    font-size: 1.1rem;
}

.summary-label {
    color: #666;
    font-weight: 500;
}

.summary-value {
    color: #333;
    font-weight: 600;
}

.summary-item.total .summary-value {
    color: #1976d2;
    font-size: 1.2rem;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    text-align: center;
    justify-content: center;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.action-btn.secondary {
    background: #f8f9fa;
    color: #333;
    border: 1px solid #e9ecef;
}

.action-btn.secondary:hover {
    background: #e9ecef;
    color: #333;
    text-decoration: none;
}

.action-btn i {
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-title {
        font-size: 2rem;
    }

    .order-status {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .status-actions {
        justify-content: center;
    }

    .card-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>
