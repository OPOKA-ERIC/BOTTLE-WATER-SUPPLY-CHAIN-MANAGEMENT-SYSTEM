@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Retailer Dashboard'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Welcome to Your Retailer Dashboard</h1>
                        <p class="welcome-subtitle">Manage your orders, track revenue, and monitor your business performance</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['total_orders'] }}</h3>
                        <p class="stats-label">Total Orders</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                            <i class="nc-icon nc-money-coins"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">UGX {{ number_format($stats['total_revenue']) }}</h3>
                        <p class="stats-label">Total Revenue</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                            <i class="nc-icon nc-time-alarm"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['pending_orders'] }}</h3>
                        <p class="stats-label">Pending Orders</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                        <h4 class="card-title">Recent Orders</h4>
                            <p class="card-subtitle">Your latest orders and their status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td><span class="order-id">#{{ $order->id }}</span></td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td><span class="amount">UGX {{ number_format($order->total_amount) }}</span></td>
                                        <td>
                                            <a href="{{ route('retailer.orders.track', $order->id) }}" class="action-btn">
                                                <i class="nc-icon nc-zoom-split-in"></i>
                                                <span>View</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Upcoming Deliveries -->
            <div class="col-md-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                        <h4 class="card-title">Upcoming Deliveries</h4>
                            <p class="card-subtitle">Your scheduled deliveries</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-delivery-fast"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($upcomingDeliveries as $delivery)
                                    <tr>
                                        <td>{{ $delivery->delivery_date->format('M d, Y') }}</td>
                                        <td><span class="order-id">#{{ $delivery->order->id }}</span></td>
                                        <td>
                                            <span class="status-badge status-{{ $delivery->status }}">
                                                {{ ucfirst($delivery->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No upcoming deliveries</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended Products -->
            <div class="col-md-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                        <h4 class="card-title">Recommended Products</h4>
                            <p class="card-subtitle">Based on your customer segment</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-pie-35"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($recommendedProducts as $product)
                            <div class="col-md-6 mb-3">
                                <div class="product-card">
                                    @if($product->image)
                                    <div class="product-image">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                    @endif
                                    <div class="product-content">
                                        <h5 class="product-title">{{ $product->name }}</h5>
                                        <p class="product-price">UGX {{ number_format($product->price) }}</p>
                                        <a href="{{ route('retailer.products.show', $product->id) }}" class="product-btn">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>View Details</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <!-- Fallback: Show 3 mineral water products -->
                            <div class="col-md-6 mb-3">
                                <div class="product-card">
                                    <div class="product-content">
                                        <h5 class="product-title">Mineral Water 500ml</h5>
                                        <p class="product-price">UGX 500</p>
                                        <span class="badge badge-info">Mineral Water</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="product-card">
                                    <div class="product-content">
                                        <h5 class="product-title">Mineral Water 1L</h5>
                                        <p class="product-price">UGX 1,000</p>
                                        <span class="badge badge-info">Mineral Water</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="product-card">
                                    <div class="product-content">
                                        <h5 class="product-title">Mineral Water 5L</h5>
                                        <p class="product-price">UGX 5,000</p>
                                        <span class="badge badge-info">Mineral Water</span>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
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

.order-id {
    font-weight: 600;
    color: #1976d2;
}

.amount {
    font-weight: 600;
    color: #2e7d32;
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

.status-completed {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-pending {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-processing {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.action-btn i {
    font-size: 14px;
}

/* Product Cards */
.product-card {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.product-image {
    height: 120px;
    overflow: hidden;
    background: #f5f5f5;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-content {
    padding: 20px;
}

.product-title {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
    line-height: 1.3;
}

.product-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #2e7d32;
    margin: 0 0 15px 0;
}

.product-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    width: 100%;
    justify-content: center;
}

.product-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.product-btn i {
    font-size: 14px;
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
}
</style>
@endsection 