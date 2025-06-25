@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Manufacturer Dashboard'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Welcome to Your Manufacturer Dashboard</h1>
                        <p class="welcome-subtitle">Manage your production, track inventory, and monitor manufacturing operations</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['total_inventory'] ?? 0 }}</h3>
                        <p class="stats-label">Total Inventory</p>
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
                        <h3 class="stats-number">{{ $stats['pending_orders'] ?? 0 }}</h3>
                        <p class="stats-label">Pending Orders</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Requires attention</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $stats['total_production'] ?? 0 }}</h3>
                        <p class="stats-label">Total Production</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>This month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Production Batches -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Production Batches</h4>
                            <p class="card-subtitle">Latest production activities and batch status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Batch ID</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Production Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBatches as $batch)
                                    <tr>
                                        <td><span class="batch-id">#{{ $batch->id }}</span></td>
                                        <td><span class="product-name">{{ $batch->product->name ?? 'N/A' }}</span></td>
                                        <td><span class="quantity">{{ number_format($batch->quantity) }}</span></td>
                                        <td>{{ $batch->production_date->format('M d, Y') }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $batch->status }}">
                                                {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('manufacturer.production.batches') }}" class="action-btn">
                                                <i class="nc-icon nc-zoom-split-in"></i>
                                                <span>View Details</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No production batches found</td>
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
            <!-- Demand Forecast -->
            @if($demandForecast)
            <div class="col-md-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Latest Demand Forecast</h4>
                            <p class="card-subtitle">Production planning insights</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-pie-35"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="forecast-content">
                            <div class="forecast-item">
                                <div class="forecast-label">Product</div>
                                <div class="forecast-value">{{ $demandForecast->product->name ?? 'Product' }}</div>
                            </div>
                            <div class="forecast-item">
                                <div class="forecast-label">Forecasted Quantity</div>
                                <div class="forecast-value">{{ number_format($demandForecast->forecasted_quantity) }}</div>
                            </div>
                            <div class="forecast-item">
                                <div class="forecast-label">Valid Until</div>
                                <div class="forecast-value">{{ $demandForecast->valid_until->format('M d, Y') }}</div>
                            </div>
                            <div class="forecast-item">
                                <div class="forecast-label">Notes</div>
                                <div class="forecast-value">{{ $demandForecast->notes ?? 'No notes available' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="col-md-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Quick Actions</h4>
                            <p class="card-subtitle">Common manufacturing tasks</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="{{ route('manufacturer.production.batches') }}" class="quick-action-btn">
                                <div class="action-icon">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Create Production Batch</span>
                                    <span class="action-subtitle">Start new production</span>
                                </div>
                            </a>
                            <a href="{{ route('manufacturer.inventory.index') }}" class="quick-action-btn">
                                <div class="action-icon">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Manage Inventory</span>
                                    <span class="action-subtitle">Update stock levels</span>
                                </div>
                            </a>
                            <a href="{{ route('page.index', 'notifications') }}" class="quick-action-btn">
                                <div class="action-icon">
                                    <i class="nc-icon nc-bell-55"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">View Notifications</span>
                                    <span class="action-subtitle">Check system alerts</span>
                                </div>
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 40px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
    margin-bottom: 30px;
}

.welcome-content {
    flex: 1;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    font-weight: 300;
}

.welcome-icon {
    font-size: 4rem;
    opacity: 0.8;
    margin-left: 30px;
}

/* Statistics Cards */
.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 5px;
}

.stats-label {
    font-size: 1rem;
    color: #7f8c8d;
    margin-bottom: 15px;
    font-weight: 500;
}

.stats-footer {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    color: #95a5a6;
}

.stats-footer i {
    margin-right: 8px;
    font-size: 0.9rem;
}

/* Content Cards */
.content-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    margin-bottom: 30px;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-content h4 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
}

.header-content p {
    margin: 5px 0 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.header-icon {
    font-size: 2rem;
    opacity: 0.8;
}

.card-body {
    padding: 30px;
}

/* Table Styling */
.table {
    margin-bottom: 0;
}

.table th {
    border-top: none;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    border-top: 1px solid #f8f9fa;
    vertical-align: middle;
    padding: 15px 8px;
}

.batch-id {
    font-weight: 600;
    color: #667eea;
}

.product-name {
    font-weight: 500;
    color: #2c3e50;
}

.quantity {
    font-weight: 600;
    color: #27ae60;
}

/* Status Badges */
.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.status-completed {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
    border: 1px solid rgba(39, 174, 96, 0.2);
}

.status-badge.status-in_progress {
    background: rgba(243, 156, 18, 0.1);
    color: #f39c12;
    border: 1px solid rgba(243, 156, 18, 0.2);
}

.status-badge.status-pending {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.2);
}

/* Action Buttons */
.action-btn {
    padding: 8px 16px;
    border-radius: 10px;
    border: none;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

/* Forecast Content */
.forecast-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.forecast-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f8f9fa;
}

.forecast-item:last-child {
    border-bottom: none;
}

.forecast-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.9rem;
}

.forecast-value {
    font-weight: 500;
    color: #2c3e50;
    text-align: right;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.quick-action-btn:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    color: inherit;
    text-decoration: none;
}

.action-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.action-content {
    flex: 1;
}

.action-title {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    font-size: 1rem;
    margin-bottom: 3px;
}

.action-subtitle {
    display: block;
    color: #7f8c8d;
    font-size: 0.85rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-card {
        flex-direction: column;
        text-align: center;
        padding: 30px 20px;
    }
    
    .welcome-icon {
        margin-left: 0;
        margin-top: 20px;
        font-size: 3rem;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .stats-card {
        padding: 20px;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .header-icon {
        align-self: flex-end;
    }
    
    .forecast-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .forecast-value {
        text-align: left;
    }
}

@media (max-width: 576px) {
    .content {
        padding-top: 80px !important;
    }
    
    .welcome-title {
        font-size: 1.8rem;
    }
    
    .stats-card {
        padding: 15px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .quick-action-btn {
        padding: 15px;
    }
}
</style>
@endsection 