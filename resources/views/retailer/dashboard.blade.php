@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Retailer Dashboard'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                        <p class="card-category">Total Orders</p>
                        <h3 class="card-title">{{ $stats['total_orders'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="nc-icon nc-refresh-69"></i> Updated just now
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="nc-icon nc-money-coins"></i>
                        </div>
                        <p class="card-category">Total Revenue</p>
                        <h3 class="card-title">${{ number_format($stats['total_revenue'], 2) }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="nc-icon nc-refresh-69"></i> Updated just now
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="nc-icon nc-time-alarm"></i>
                        </div>
                        <p class="card-category">Pending Orders</p>
                        <h3 class="card-title">{{ $stats['pending_orders'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="nc-icon nc-refresh-69"></i> Updated just now
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Recent Orders</h4>
                        <p class="card-category">Your latest orders</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
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
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('retailer.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                <i class="nc-icon nc-zoom-split-in"></i> View
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-info">
                        <h4 class="card-title">Upcoming Deliveries</h4>
                        <p class="card-category">Your scheduled deliveries</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-info">
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
                                        <td>#{{ $delivery->order->id }}</td>
                                        <td>
                                            <span class="badge badge-{{ $delivery->status === 'completed' ? 'success' : ($delivery->status === 'pending' ? 'warning' : 'info') }}">
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">Recommended Products</h4>
                        <p class="card-category">Based on your customer segment</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($recommendedProducts as $product)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">${{ number_format($product->price, 2) }}</p>
                                        <a href="{{ route('retailer.products.show', $product->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <p class="text-center">No recommended products available</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 