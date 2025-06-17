@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Supplier Dashboard'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                        <p class="card-category">Total Materials</p>
                        <h3 class="card-title">{{ $stats['total_materials'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{ route('supplier.materials') }}">View all materials</a>
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
                        <p class="card-category">Total Sales</p>
                        <h3 class="card-title">${{ number_format($stats['total_sales'], 2) }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> Last 30 days
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                        <p class="card-category">Pending Orders</p>
                        <h3 class="card-title">{{ $stats['pending_orders'] }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">local_offer</i> Requires attention
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
                        <p class="card-category">Latest purchase orders from manufacturers</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Manufacturer</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->manufacturer->name }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('supplier.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No recent orders found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Chats -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Recent Messages</h4>
                        <p class="card-category">Latest communications with manufacturers</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Manufacturer</th>
                                        <th>Message</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentChats as $chat)
                                    <tr>
                                        <td>{{ $chat->manufacturer->name }}</td>
                                        <td>{{ Str::limit($chat->message, 50) }}</td>
                                        <td>{{ ucfirst($chat->type) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $chat->is_read ? 'success' : 'warning' }}">
                                                {{ $chat->is_read ? 'Read' : 'Unread' }}
                                            </span>
                                        </td>
                                        <td>{{ $chat->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('supplier.chats.show', $chat->id) }}" class="btn btn-sm btn-info">
                                                View Conversation
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No recent messages found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 