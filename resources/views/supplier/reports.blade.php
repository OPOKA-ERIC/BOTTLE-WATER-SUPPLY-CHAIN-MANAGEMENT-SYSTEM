@extends('layouts.app', ['activePage' => 'reports', 'title' => 'Supplier Reports'])

@section('content')
<div class="content" style="margin-top: 40px !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header" style="background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%); color: white; padding: 25px 30px; display: flex; align-items: center; justify-content: space-between; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <div class="header-content">
                            <h4 class="card-title" style="color: white; font-size: 1.5rem; font-weight: 700; margin: 0 0 5px 0; line-height: 1.2;">Supplier Activity Report</h4>
                            <p class="card-subtitle" style="color: white; font-size: 0.95rem; margin: 0; opacity: 0.9; font-weight: 400;">Summary of your orders and materials</p>
                        </div>
                        <div class="header-icon" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-left: 20px;">
                            <i class="nc-icon nc-single-copy-04" style="font-size: 24px; color: white;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Date:</strong> {{ now()->format('Y-m-d H:i') }}</p>
                        <div class="row mt-4 mb-4">
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-icon"><i class="nc-icon nc-money-coins"></i></div>
                                    <div class="stats-content">
                                        <h3 class="stats-number">UGX {{ number_format($stats['total_sales'], 0) }}/=</h3>
                                        <p class="stats-label">Total Sales</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-icon"><i class="nc-icon nc-cart-simple"></i></div>
                                    <div class="stats-content">
                                        <h3 class="stats-number">{{ $stats['pending_orders'] }}</h3>
                                        <p class="stats-label">Pending Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-icon"><i class="nc-icon nc-check-2"></i></div>
                                    <div class="stats-content">
                                        <h3 class="stats-number">{{ $stats['completed_orders'] }}</h3>
                                        <p class="stats-label">Completed Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-card">
                                    <div class="stats-icon"><i class="nc-icon nc-box-2"></i></div>
                                    <div class="stats-content">
                                        <h3 class="stats-number">{{ $stats['total_materials'] }}</h3>
                                        <p class="stats-label">Total Materials</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-4">Orders</h5>
                        @if($orders->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Manufacturer</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->manufacturer->name ?? '-' }}</td>
                                        <td>{{ ucfirst($order->status) }}</td>
                                        <td>UGX {{ number_format($order->total_amount, 0) }}/=</td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="alert alert-info mt-4">No orders found.</div>
                        @endif
                        <h5 class="mt-4">Materials</h5>
                        @if($materials->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($materials as $material)
                                    <tr>
                                        <td>{{ $material->name }}</td>
                                        <td>{{ $material->quantity_available }}</td>
                                        <td>UGX {{ number_format($material->price, 0) }}/=</td>
                                        <td>UGX {{ number_format($material->quantity_available * $material->price, 0) }}/=</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="alert alert-info mt-4">No materials found.</div>
                        @endif
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('supplier.reports.download') }}" class="btn btn-primary" target="_blank" rel="noopener">
                                <i class="nc-icon nc-single-copy-04"></i> Download PDF Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 