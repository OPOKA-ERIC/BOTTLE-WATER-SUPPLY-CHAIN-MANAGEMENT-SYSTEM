@extends('layouts.app', ['activePage' => 'orders', 'title' => 'Order Management'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Order Management</h1>
                        <p class="welcome-subtitle">Process orders, assign deliveries, and track status</p>
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
                        <i class="nc-icon nc-time-alarm"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $orders->where('status', 'pending')->count() }}</h3>
                        <p class="stats-label">Pending Orders</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Awaiting processing</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $orders->where('status', 'processing')->count() }}</h3>
                        <p class="stats-label">Processing</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>In production</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-delivery-fast"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $orders->where('status', 'shipped')->count() }}</h3>
                        <p class="stats-label">Shipped</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>In transit</span>
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
                        <h3 class="stats-number">{{ $orders->where('status', 'delivered')->count() }}</h3>
                        <p class="stats-label">Delivered</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="row">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">All Orders</h4>
                            <p class="card-subtitle">Manage and process customer orders</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Products</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Delivery Date</th>
                                            <th>Delivery Status</th>
                                            <th>Next Action</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr class="order-row" data-order-id="{{ $order->id }}">
                                                <td><span class="order-id">#{{ $order->id }}</span></td>
                                                <td>
                                                    <div class="customer-info">
                                                        <span class="customer-name">{{ $order->retailer->name }}</span>
                                                        <span class="customer-email">{{ $order->retailer->email }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="products-list">
                                                        @foreach($order->products as $product)
                                                            <span class="product-badge">{{ $product->name }} ({{ $product->pivot->quantity }})</span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td><span class="amount">UGX {{ number_format($order->total_amount) }}</span></td>
                                                <td>
                                                    <span class="status-badge status-{{ $order->status }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td><span class="date-text">{{ $order->delivery_date->format('M d, Y') }}</span></td>
                                                <td>
                                                    @if($order->deliverySchedule)
                                                        <span class="status-badge status-{{ $order->deliverySchedule->status }}">
                                                            {{ ucfirst(str_replace('_', ' ', $order->deliverySchedule->status)) }}
                                                        </span>
                                                    @else
                                                        <span class="status-badge status-pending">No Schedule</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->status === 'pending')
                                                        <span class="next-action-badge process">Start Processing</span>
                                                    @elseif($order->status === 'processing')
                                                        <span class="next-action-badge assign">Assign Delivery</span>
                                                    @elseif($order->deliverySchedule && $order->deliverySchedule->status === 'assigned')
                                                        <span class="next-action-badge update">Update Delivery</span>
                                                    @elseif($order->status === 'shipped' && $order->deliverySchedule && $order->deliverySchedule->status === 'in_transit')
                                                        <span class="next-action-badge deliver">Mark as Delivered</span>
                                                    @elseif($order->status === 'shipped' && $order->deliverySchedule && $order->deliverySchedule->status !== 'delivered' && $order->deliverySchedule->status !== 'failed')
                                                        <span class="next-action-badge deliver">Mark as Delivered</span>
                                                    @elseif($order->status === 'shipped')
                                                        <span class="next-action-badge track">Track Delivery</span>
                                                    @elseif($order->status === 'delivered')
                                                        <span class="next-action-badge completed">Completed</span>
                                                    @else
                                                        <span class="next-action-badge pending">No Action</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="action-btn primary" onclick="viewOrderDetails({{ $order->id }})" title="View Details">
                                                            <i class="nc-icon nc-zoom-split-in"></i>
                                                            <span class="btn-text">View</span>
                                                        </button>
                                                        @if($order->status === 'pending')
                                                            <button class="action-btn success" onclick="processOrder({{ $order->id }})" title="Start Processing">
                                                                <i class="nc-icon nc-settings-gear-65"></i>
                                                                <span class="btn-text">Process</span>
                                                            </button>
                                                        @endif
                                                        @if($order->status === 'processing')
                                                            <button class="action-btn warning" onclick="assignDelivery({{ $order->id }})" title="Assign Delivery">
                                                                <i class="nc-icon nc-delivery-fast"></i>
                                                                <span class="btn-text">Assign</span>
                                                            </button>
                                                        @endif
                                                        @if($order->deliverySchedule && $order->deliverySchedule->status === 'assigned')
                                                            <button class="action-btn info" onclick="updateDeliveryStatus({{ $order->deliverySchedule->id }})" title="Update Delivery">
                                                                <i class="nc-icon nc-refresh-69"></i>
                                                                <span class="btn-text">Update</span>
                                                            </button>
                                                        @endif
                                                        @if($order->status === 'shipped' && $order->deliverySchedule && $order->deliverySchedule->status !== 'delivered' && $order->deliverySchedule->status !== 'failed')
                                                            <button class="action-btn success" onclick="markAsDelivered({{ $order->deliverySchedule->id }})" title="Mark as Delivered">
                                                                <i class="nc-icon nc-check-2"></i>
                                                                <span class="btn-text">Mark Delivered</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="pagination-container">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-cart-simple"></i>
                                </div>
                                <h3 class="empty-title">No Orders Found</h3>
                                <p class="empty-subtitle">There are no orders to process at the moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Process Order Modal -->
<div class="modal fade" id="processOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🔄 Process Order</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="processOrderForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <strong>Processing Order:</strong> Update the order status to begin fulfillment.
                    </div>
                    <div class="form-group">
                        <label for="order_status">Order Status</label>
                        <select class="form-control" id="order_status" name="status" required>
                            <option value="processing">⚙️ Processing - Start preparing the order</option>
                            <option value="shipped">🚚 Shipped - Order is on its way</option>
                            <option value="delivered">✅ Delivered - Order completed</option>
                            <option value="cancelled">❌ Cancelled - Order cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_notes">Notes</label>
                        <textarea class="form-control" id="order_notes" name="notes" rows="3" placeholder="Add any notes about this order..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Assign Delivery Modal -->
<div class="modal fade" id="assignDeliveryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🚚 Assign Delivery</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="assignDeliveryForm">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="nc-icon nc-delivery-fast"></i>
                        <strong>Assign Delivery:</strong> Select a driver and vehicle for this delivery.
                    </div>
                    <div class="form-group">
                        <label for="driver_id">Driver</label>
                        <select class="form-control" id="driver_id" name="driver_id" required>
                            <option value="">👤 Select Driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">👤 {{ $driver->name }} ({{ $driver->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_id">Vehicle</label>
                        <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                            <option value="">🚗 Select Vehicle</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">🚗 {{ $vehicle->plate_number }} - {{ $vehicle->model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="delivery_notes">Delivery Notes</label>
                        <textarea class="form-control" id="delivery_notes" name="delivery_notes" rows="3" placeholder="Add delivery instructions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Delivery</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Delivery Status Modal -->
<div class="modal fade" id="updateDeliveryStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📊 Update Delivery Status</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="updateDeliveryStatusForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="nc-icon nc-refresh-69"></i>
                        <strong>Update Delivery:</strong> Track the progress of this delivery.
                    </div>
                    <div class="form-group">
                        <label for="delivery_status">Delivery Status</label>
                        <select class="form-control" id="delivery_status" name="status" required>
                            <option value="in_transit">🚚 In Transit - Delivery is on the way</option>
                            <option value="delivered">✅ Delivered - Successfully delivered</option>
                            <option value="failed">❌ Failed - Delivery failed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="delivery_status_notes">Notes</label>
                        <textarea class="form-control" id="delivery_status_notes" name="notes" rows="3" placeholder="Add delivery status notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Content spacing */
.content {
    padding-top: 100px !important;
    margin-top: 0;
}

/* Welcome Card */
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
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

/* Statistics Cards */
.stats-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    text-align: center;
}

.stats-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    margin: 0 auto 20px;
}

.stats-content {
    padding: 20px;
}

.stats-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.8;
}

.stats-footer {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

/* Orders Card */
.content-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
}

.card-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: white;
    margin: 0 0 5px 0;
}

.card-subtitle {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.card-body {
    padding: 30px;
}

/* Table Styles */
.table {
    margin: 0;
}

.table thead th {
    background: rgba(25, 118, 210, 0.05);
    border: none;
    padding: 15px;
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.table tbody td {
    padding: 15px;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.order-row {
    transition: all 0.3s ease;
}

.order-row:hover {
    background: rgba(25, 118, 210, 0.05);
    transform: translateX(5px);
}

.order-id {
    font-weight: 600;
    color: #1976d2;
    font-size: 1.1rem;
}

.customer-info {
    display: flex;
    flex-direction: column;
}

.customer-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.customer-email {
    font-size: 0.8rem;
    color: #666;
}

.products-list {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.product-badge {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
}

.amount {
    font-weight: 600;
    color: #2e7d32;
    font-size: 1rem;
}

.date-text {
    color: #666;
    font-size: 0.9rem;
}

/* Status Badges */
.status-badge {
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

.status-shipped {
    background: rgba(156, 39, 176, 0.1);
    color: #9c27b0;
}

.status-delivered {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-cancelled {
    background: rgba(211, 47, 47, 0.1);
    color: #d32f2f;
}

.status-scheduled {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

.status-assigned {
    background: rgba(156, 39, 176, 0.1);
    color: #9c27b0;
}

.status-in-transit {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-failed {
    background: rgba(211, 47, 47, 0.1);
    color: #d32f2f;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.action-btn {
    min-width: 80px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    color: white;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    padding: 0 12px;
}

.action-btn i {
    font-size: 14px;
}

.action-btn .btn-text {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.action-btn.success {
    background: linear-gradient(135deg, #46c35f, #2e7d32);
    box-shadow: 0 2px 8px rgba(70, 195, 95, 0.3);
}

.action-btn.warning {
    background: linear-gradient(135deg, #ff9800, #f57c00);
    box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
}

.action-btn.info {
    background: linear-gradient(135deg, #2196f3, #1976d2);
    box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3);
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    color: white;
    text-decoration: none;
}

.action-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: #666;
    font-size: 32px;
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

/* Pagination */
.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        padding-top: 120px !important;
    }
    
    .welcome-card {
        flex-direction: column;
        text-align: center;
        gap: 20px;
        padding: 30px 20px;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .stats-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 5px;
    }
    
    .action-btn {
        min-width: 70px;
        height: 32px;
        font-size: 10px;
        padding: 0 8px;
    }
    
    .action-btn .btn-text {
        font-size: 10px;
    }
    
    .next-action-badge {
        font-size: 0.7rem;
        min-width: 80px;
        padding: 4px 8px;
    }
}

/* Next Action Badges */
.next-action-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    text-align: center;
    min-width: 100px;
}

.next-action-badge.process {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
    border: 1px solid rgba(25, 118, 210, 0.2);
}

.next-action-badge.assign {
    background: rgba(255, 152, 0, 0.1);
    color: #f57c00;
    border: 1px solid rgba(255, 152, 0, 0.2);
}

.next-action-badge.update {
    background: rgba(33, 150, 243, 0.1);
    color: #1976d2;
    border: 1px solid rgba(33, 150, 243, 0.2);
}

.next-action-badge.track {
    background: rgba(156, 39, 176, 0.1);
    color: #9c27b0;
    border: 1px solid rgba(156, 39, 176, 0.2);
}

.next-action-badge.deliver {
    background: rgba(76, 175, 80, 0.1);
    color: #4caf50;
    border: 1px solid rgba(76, 175, 80, 0.2);
}

.next-action-badge.completed {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    border: 1px solid rgba(46, 125, 50, 0.2);
}

.next-action-badge.pending {
    background: rgba(158, 158, 158, 0.1);
    color: #757575;
    border: 1px solid rgba(158, 158, 158, 0.2);
}
</style>

@push('js')
<script>
// Debug function to check if everything is loaded
function debugProcessButton() {
    console.log('=== DEBUGGING PROCESS BUTTON ===');
    console.log('jQuery loaded:', typeof $ !== 'undefined');
    console.log('Bootstrap modal available:', typeof $.fn.modal !== 'undefined');
    console.log('processOrderModal exists:', $('#processOrderModal').length > 0);
    console.log('processOrderForm exists:', $('#processOrderForm').length > 0);
    console.log('CSRF token:', $('meta[name="csrf-token"]').attr('content'));
}

// Global variables
let currentOrderId = null;
let currentDeliveryId = null;

// Function to view order details
function viewOrderDetails(orderId) {
    console.log('viewOrderDetails called with orderId:', orderId);
    fetch(`/manufacturer/orders/${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const order = data.order;
                const content = `
                    <div class="order-details">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Order Information</h6>
                                <p><strong>Order ID:</strong> #${order.id}</p>
                                <p><strong>Status:</strong> <span class="status-badge status-${order.status}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></p>
                                <p><strong>Order Date:</strong> ${new Date(order.created_at).toLocaleDateString()}</p>
                                <p><strong>Delivery Date:</strong> ${new Date(order.delivery_date).toLocaleDateString()}</p>
                                <p><strong>Total Amount:</strong> UGX ${parseInt(order.total_amount).toLocaleString()}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Customer Information</h6>
                                <p><strong>Name:</strong> ${order.retailer.name}</p>
                                <p><strong>Email:</strong> ${order.retailer.email}</p>
                                <p><strong>Delivery Address:</strong> ${order.delivery_address}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Products</h6>
                                <div class="products-list">
                                    ${order.products.map(product => `
                                        <span class="product-badge">${product.name} (${product.pivot.quantity}) - UGX ${parseInt(product.pivot.price).toLocaleString()}</span>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                        ${order.delivery_schedule ? `
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Delivery Information</h6>
                                <p><strong>Status:</strong> <span class="status-badge status-${order.delivery_schedule.status}">${order.delivery_schedule.status.replace('_', ' ').charAt(0).toUpperCase() + order.delivery_schedule.status.replace('_', ' ').slice(1)}</span></p>
                                ${order.delivery_schedule.driver ? `<p><strong>Driver:</strong> ${order.delivery_schedule.driver.name}</p>` : ''}
                                ${order.delivery_schedule.vehicle ? `<p><strong>Vehicle:</strong> ${order.delivery_schedule.vehicle.plate_number}</p>` : ''}
                                ${order.delivery_schedule.notes ? `<p><strong>Notes:</strong> ${order.delivery_schedule.notes}</p>` : ''}
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;
                document.getElementById('orderDetailsContent').innerHTML = content;
                $('#orderDetailsModal').modal('show');
            } else {
                alert('Failed to load order details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load order details');
        });
}

// Function to process order
function processOrder(orderId) {
    console.log('processOrder called with orderId:', orderId);
    currentOrderId = orderId;
    
    // Reset form and show modal
    if ($('#processOrderForm').length > 0) {
        $('#processOrderForm')[0].reset();
        $('#processOrderModal').modal('show');
        console.log('Modal should be showing now');
    } else {
        console.error('processOrderForm not found!');
        alert('Error: Form not found. Please refresh the page.');
    }
}

// Function to assign delivery
function assignDelivery(orderId) {
    console.log('assignDelivery called with orderId:', orderId);
    currentOrderId = orderId;
    $('#assignDeliveryForm')[0].reset();
    $('#assignDeliveryModal').modal('show');
}

// Function to update delivery status
function updateDeliveryStatus(deliveryId) {
    console.log('updateDeliveryStatus called with deliveryId:', deliveryId);
    currentDeliveryId = deliveryId;
    $('#updateDeliveryStatusForm')[0].reset();
    $('#updateDeliveryStatusModal').modal('show');
}

// Function to mark as delivered
function markAsDelivered(deliveryId) {
    console.log('markAsDelivered called with deliveryId:', deliveryId);
    currentDeliveryId = deliveryId;
    $('#updateDeliveryStatusForm')[0].reset();
    $('#delivery_status').val('delivered');
    $('#updateDeliveryStatusModal').modal('show');
}

// Document ready function
$(document).ready(function() {
    // Call debug function when page loads
    debugProcessButton();
    
    // Process Order Form Submission
    $('#processOrderForm').on('submit', function(e) {
        e.preventDefault();
        console.log('processOrderForm submitted');
        
        if (!currentOrderId) {
            alert('Error: No order selected');
            return;
        }
        
        const formData = new FormData(this);
        console.log('Form data:', {
            status: formData.get('status'),
            notes: formData.get('notes')
        });
        
        fetch(`/manufacturer/orders/${currentOrderId}/process`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(formData)
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                $('#processOrderModal').modal('hide');
                alert('Order processed successfully!');
                location.reload();
            } else {
                alert(data.message || 'Failed to process order');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to process order. Check console for details.');
        });
    });

    // Assign Delivery Form Submission
    $('#assignDeliveryForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(`/manufacturer/orders/${currentOrderId}/assign-delivery`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#assignDeliveryModal').modal('hide');
                location.reload();
            } else {
                alert(data.message || 'Failed to assign delivery');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to assign delivery');
        });
    });

    // Update Delivery Status Form Submission
    $('#updateDeliveryStatusForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('delivery_schedule_id', currentDeliveryId);
        
        fetch(`/manufacturer/orders/${currentDeliveryId}/update-delivery`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#updateDeliveryStatusModal').modal('hide');
                location.reload();
            } else {
                alert(data.message || 'Failed to update delivery status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update delivery status');
        });
    });
});
</script>
@endpush
@endsection 