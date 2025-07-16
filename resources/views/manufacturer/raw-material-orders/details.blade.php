@extends('layouts.app', ['activePage' => 'raw-material-orders', 'title' => 'Order Details'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Order Details</h1>
                        <p class="welcome-subtitle">View details of your raw material order</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">{{ $order->order_number ?? 'Order #' . $order->id }}</h4>
                            <p class="card-subtitle">Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Order Status -->
                        <div class="order-status-section mb-4">
                            <div class="status-badge status-{{ $order->status }}">
                                <i class="nc-icon {{ $order->status === 'completed' ? 'nc-check-2' : ($order->status === 'processing' ? 'nc-settings-gear-65' : ($order->status === 'cancelled' ? 'nc-simple-remove' : 'nc-time-alarm')) }}"></i>
                                {{ ucfirst($order->status) }}
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="order-items-section">
                            <h5 class="section-title">Order Items</h5>
                            <div class="items-list">
                                @foreach($order->items as $item)
                                    <div class="item-card">
                                        <div class="item-header">
                                            <div class="item-name">{{ $item->rawMaterial->name }}</div>
                                            <div class="item-price">UGX {{ number_format($item->total_price, 0) }}/=</div>
                                        </div>
                                        <div class="item-details">
                                            <div class="item-quantity">
                                                <span class="detail-label">Quantity:</span>
                                                <span class="detail-value">{{ $item->quantity }} {{ $item->rawMaterial->unit_of_measure }}</span>
                                            </div>
                                            <div class="item-unit-price">
                                                <span class="detail-label">Unit Price:</span>
                                                <span class="detail-value">UGX {{ number_format($item->unit_price, 0) }}/=</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Notes -->
                        @if($order->notes)
                            <div class="order-notes-section mt-4">
                                <h5 class="section-title">Order Notes</h5>
                                <div class="notes-content">
                                    {{ $order->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Order Summary</h4>
                            <p class="card-subtitle">Order details and supplier information</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-pie-35"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Supplier Information -->
                        <div class="supplier-info mb-4">
                            <h6 class="info-title">Supplier Information</h6>
                            <div class="info-item">
                                <span class="info-label">Name:</span>
                                <span class="info-value">{{ $order->supplier->name ?? 'Unknown' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $order->supplier->email ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="order-details mb-4">
                            <h6 class="info-title">Order Details</h6>
                            <div class="info-item">
                                <span class="info-label">Order Number:</span>
                                <span class="info-value">{{ $order->order_number ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Order Date:</span>
                                <span class="info-value">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Delivery Date:</span>
                                <span class="info-value">{{ $order->expected_delivery_date ? $order->expected_delivery_date->format('M d, Y') : 'Not specified' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Items:</span>
                                <span class="info-value">{{ $order->items->count() }}</span>
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <div class="total-amount">
                            <div class="amount-label">Total Amount</div>
                            <div class="amount-value">UGX {{ number_format($order->total_amount, 0) }}/=</div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons mt-4">
                            <a href="{{ route('manufacturer.raw-material-orders') }}" class="btn btn-outline-primary btn-block">
                                <i class="nc-icon nc-arrow-left"></i>
                                Back to Orders
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
}

.card-subtitle {
    font-size: 0.9rem;
    margin: 0;
    opacity: 0.9;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
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
.order-status-section {
    text-align: center;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1.1rem;
}

.status-pending {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    color: #856404;
}

.status-processing {
    background: linear-gradient(135deg, #cce5ff, #74b9ff);
    color: #004085;
}

.status-completed {
    background: linear-gradient(135deg, #d4edda, #00b894);
    color: #155724;
}

.status-cancelled {
    background: linear-gradient(135deg, #f8d7da, #fd79a8);
    color: #721c24;
}

/* Section Titles */
.section-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

/* Order Items */
.items-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.item-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.item-card:hover {
    background: #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.item-name {
    font-weight: 600;
    color: #333;
    font-size: 1.1rem;
}

.item-price {
    color: #1976d2;
    font-weight: 600;
    font-size: 1.1rem;
}

.item-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.item-quantity, .item-unit-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-label {
    color: #666;
    font-size: 0.9rem;
}

.detail-value {
    font-weight: 500;
    color: #333;
}

/* Order Notes */
.notes-content {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    border-left: 4px solid #1976d2;
    font-style: italic;
    color: #555;
}

/* Information Sections */
.info-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e9ecef;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f1f3f4;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    color: #666;
    font-size: 0.9rem;
}

.info-value {
    font-weight: 500;
    color: #333;
}

/* Total Amount */
.total-amount {
    background: linear-gradient(135deg, #1976d2, #1565c0);
    color: white;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
}

.amount-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 5px;
}

.amount-value {
    font-size: 1.5rem;
    font-weight: 700;
}

/* Buttons */
.btn {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-outline-primary {
    border: 2px solid #1976d2;
    color: #1976d2;
    background: transparent;
}

.btn-outline-primary:hover {
    background: #1976d2;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

.btn-block {
    width: 100%;
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
    
    .card-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .header-icon {
        margin: 0;
    }
    
    .item-details {
        grid-template-columns: 1fr;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
}
</style>
@endsection 