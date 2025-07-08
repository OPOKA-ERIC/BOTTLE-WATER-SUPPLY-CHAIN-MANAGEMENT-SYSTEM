@extends('layouts.app', ['activePage' => 'orders', 'title' => 'Track Order'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header-card">
                    <div class="header-content">
                        <h1 class="page-title">Track Order #{{ $order->id }}</h1>
                        <p class="page-subtitle">Monitor your order status and delivery progress</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('retailer.orders.index') }}" class="back-btn">
                            <i class="nc-icon nc-minimal-left"></i>
                            <span>Back to Orders</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="row">
            <div class="col-lg-8">
                <div class="order-details-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Order Information</h4>
                            <p class="card-subtitle">Complete order details and status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="info-label">Order ID</label>
                                    <span class="info-value">#{{ $order->id }}</span>
                                </div>
                                <div class="info-group">
                                    <label class="info-label">Order Date</label>
                                    <span class="info-value">{{ $order->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="info-group">
                                    <label class="info-label">Status</label>
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <label class="info-label">Delivery Address</label>
                                    <span class="info-value">{{ $order->delivery_address }}</span>
                                </div>
                                <div class="info-group">
                                    <label class="info-label">Delivery Date</label>
                                    <span class="info-value">{{ $order->delivery_date->format('M d, Y') }}</span>
                                </div>
                                <div class="info-group">
                                    <label class="info-label">Total Amount</label>
                                    <span class="info-value amount">UGX {{ number_format($order->total_amount) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products List -->
                <div class="products-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Ordered Products</h4>
                            <p class="card-subtitle">Products in this order</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->products as $product)
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <span class="product-name">{{ $product->name }}</span>
                                                @if($product->volume)
                                                    <span class="product-details">{{ $product->volume }} {{ $product->unit ?? 'ml' }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td><span class="quantity-badge">{{ $product->pivot->quantity }}</span></td>
                                        <td><span class="price">UGX {{ number_format($product->pivot->price) }}</span></td>
                                        <td><span class="total">UGX {{ number_format($product->pivot->quantity * $product->pivot->price) }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Tracking -->
            <div class="col-lg-4">
                <div class="delivery-tracking-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Delivery Tracking</h4>
                            <p class="card-subtitle">Real-time delivery status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-delivery-fast"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($order->deliverySchedule)
                            <div class="tracking-timeline">
                                <div class="timeline-item completed">
                                    <div class="timeline-icon">
                                        <i class="nc-icon nc-check-2"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Order Placed</h6>
                                        <p class="timeline-time">{{ $order->created_at->format('M d, Y H:i') }}</p>
                                        <p class="timeline-description">Your order has been successfully placed</p>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $order->status !== 'pending' ? 'completed' : 'pending' }}">
                                    <div class="timeline-icon">
                                        <i class="nc-icon nc-settings-gear-65"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Processing</h6>
                                        <p class="timeline-time">{{ $order->status !== 'pending' ? $order->updated_at->format('M d, Y H:i') : 'Pending' }}</p>
                                        <p class="timeline-description">Order is being processed by manufacturer</p>
                                    </div>
                                </div>

                                <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : 'pending' }}">
                                    <div class="timeline-icon">
                                        <i class="nc-icon nc-delivery-fast"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Shipped</h6>
                                        <p class="timeline-time">{{ in_array($order->status, ['shipped', 'delivered']) ? 'In Progress' : 'Pending' }}</p>
                                        <p class="timeline-description">Order is on its way to you</p>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : 'pending' }}">
                                    <div class="timeline-icon">
                                        <i class="nc-icon nc-check-2"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">Delivered</h6>
                                        <p class="timeline-time">{{ $order->status === 'delivered' ? 'Completed' : 'Pending' }}</p>
                                        <p class="timeline-description">Order has been delivered to your address</p>
                                    </div>
                                </div>
                            </div>

                            @if($order->deliverySchedule)
                                <div class="delivery-info">
                                    <h6 class="delivery-title">Delivery Schedule</h6>
                                    <div class="delivery-details">
                                        <p><strong>Date:</strong> {{ $order->deliverySchedule->delivery_date->format('M d, Y') }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="status-badge status-{{ $order->deliverySchedule->status }}">
                                                {{ ucfirst($order->deliverySchedule->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="no-tracking">
                                <div class="no-tracking-icon">
                                    <i class="nc-icon nc-delivery-fast"></i>
                                </div>
                                <h6 class="no-tracking-title">No Tracking Available</h6>
                                <p class="no-tracking-description">Delivery tracking information will be available once your order is processed.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Content spacing to account for fixed navbar */
.content {
    padding-top: 100px !important;
    margin-top: 0;
}

/* Page Header */
.page-header-card {
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

.header-content {
    flex: 1;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.9;
    font-weight: 400;
}

.header-actions {
    display: flex;
    align-items: center;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

/* Cards */
.order-details-card,
.products-card,
.delivery-tracking-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    margin-bottom: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.header-content {
    flex: 1;
}

.card-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 5px 0;
}

.card-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
}

.header-icon {
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

.card-body {
    padding: 30px;
}

/* Info Groups */
.info-group {
    margin-bottom: 20px;
}

.info-label {
    display: block;
    font-size: 0.85rem;
    color: #666;
    font-weight: 500;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    display: block;
    font-size: 1.1rem;
    color: #333;
    font-weight: 600;
}

.amount {
    color: #2e7d32;
    font-size: 1.2rem;
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

.status-completed {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
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

.table tbody tr:hover {
    background: rgba(25, 118, 210, 0.05);
}

.product-info {
    display: flex;
    flex-direction: column;
}

.product-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.product-details {
    font-size: 0.8rem;
    color: #666;
}

.quantity-badge {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
}

.price, .total {
    font-weight: 600;
    color: #2e7d32;
}

/* Timeline */
.tracking-timeline {
    position: relative;
    padding-left: 30px;
}

.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: rgba(0, 0, 0, 0.1);
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-icon {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
    z-index: 2;
}

.timeline-item.completed .timeline-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.timeline-item.pending .timeline-icon {
    background: rgba(0, 0, 0, 0.1);
    color: #666;
}

.timeline-content {
    background: rgba(255, 255, 255, 0.8);
    padding: 15px;
    border-radius: 10px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.timeline-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 5px 0;
}

.timeline-time {
    font-size: 0.8rem;
    color: #666;
    margin: 0 0 5px 0;
}

.timeline-description {
    font-size: 0.85rem;
    color: #666;
    margin: 0;
}

/* Delivery Info */
.delivery-info {
    margin-top: 30px;
    padding: 20px;
    background: rgba(25, 118, 210, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(25, 118, 210, 0.1);
}

.delivery-title {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 15px 0;
}

.delivery-details p {
    margin: 0 0 8px 0;
    font-size: 0.9rem;
    color: #666;
}

.delivery-details p:last-child {
    margin-bottom: 0;
}

/* No Tracking */
.no-tracking {
    text-align: center;
    padding: 40px 20px;
}

.no-tracking-icon {
    width: 60px;
    height: 60px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: #666;
    font-size: 24px;
}

.no-tracking-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
}

.no-tracking-description {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
    line-height: 1.5;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        padding-top: 120px !important;
    }
    
    .page-header-card {
        flex-direction: column;
        text-align: center;
        gap: 20px;
        padding: 30px 20px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .header-icon {
        margin: 0;
    }
    
    .tracking-timeline {
        padding-left: 20px;
    }
    
    .tracking-timeline::before {
        left: 10px;
    }
    
    .timeline-item {
        padding-left: 15px;
    }
    
    .timeline-icon {
        left: -17px;
        width: 20px;
        height: 20px;
        font-size: 10px;
    }
}
</style>
@endsection 