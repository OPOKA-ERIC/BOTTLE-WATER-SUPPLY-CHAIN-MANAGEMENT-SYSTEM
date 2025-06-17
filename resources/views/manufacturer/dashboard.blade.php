@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Manufacturer Dashboard'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">inventory_2</i>
                        </div>
                        <p class="card-category">Total Inventory</p>
                        <h3 class="card-title">{{ $stats['total_inventory'] ?? 0 }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">update</i> Just Updated
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">pending_actions</i>
                        </div>
                        <p class="card-category">Pending Orders</p>
                        <h3 class="card-title">{{ $stats['pending_orders'] ?? 0 }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">update</i> Just Updated
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">factory</i>
                        </div>
                        <p class="card-category">Total Production</p>
                        <h3 class="card-title">{{ $stats['total_production'] ?? 0 }}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">update</i> Just Updated
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Production Batches -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Recent Production Batches</h4>
                        <p class="card-category">Latest production activities</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Production Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBatches as $batch)
                                    <tr>
                                        <td>{{ $batch->id }}</td>
                                        <td>{{ $batch->product->name ?? 'N/A' }}</td>
                                        <td>{{ $batch->quantity }}</td>
                                        <td>{{ $batch->production_date->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $batch->status === 'completed' ? 'success' : ($batch->status === 'in_progress' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($batch->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No production batches found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demand Forecast -->
        @if($demandForecast)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Latest Demand Forecast</h4>
                        <p class="card-category">Forecast for {{ $demandForecast->product->name ?? 'Product' }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Forecasted Quantity: {{ $demandForecast->forecasted_quantity }}</h5>
                                <p>Valid Until: {{ $demandForecast->valid_until->format('Y-m-d') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Notes:</h5>
                                <p>{{ $demandForecast->notes ?? 'No notes available' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Initialize any JavaScript components here
    });
</script>
@endpush 