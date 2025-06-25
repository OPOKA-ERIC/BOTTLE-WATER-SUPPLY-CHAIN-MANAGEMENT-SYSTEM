@extends('layouts.app', ['activePage' => 'materials', 'title' => 'Materials Management'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Materials Management</h1>
                        <p class="welcome-subtitle">Track your raw materials inventory, monitor stock levels, and manage pricing</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
    <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $materials->count() }}</h3>
                        <p class="stats-label">Total Materials</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>In inventory</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-chart-bar-32"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $materials->where('status', 'available')->count() }}</h3>
                        <p class="stats-label">Available</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>In stock</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-alert-circle-i"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $materials->where('status', 'low_stock')->count() }}</h3>
                        <p class="stats-label">Low Stock</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Needs attention</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-money-coins"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">${{ number_format($materials->sum('price'), 2) }}</h3>
                        <p class="stats-label">Total Value</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Inventory worth</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Raw Materials Inventory</h4>
                            <p class="card-subtitle">Manage your raw materials and track stock levels</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                </div>
                <div class="card-body">
                    @if(isset($materials) && $materials->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Material Name</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $material)
                                        <tr>
                                                <td>
                                                    <div class="material-info">
                                                        <span class="material-name">{{ $material->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="material-description">{{ Str::limit($material->description, 50) }}</span>
                                                </td>
                                                <td>
                                                    <span class="quantity-badge quantity-{{ $material->quantity > 100 ? 'high' : ($material->quantity > 50 ? 'medium' : 'low') }}">
                                                        {{ $material->quantity }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="price-label">${{ number_format($material->price, 2) }}</span>
                                                </td>
                                                <td>
                                                    <span class="status-badge status-{{ $material->status }}">
                                                        <i class="nc-icon {{ $material->status === 'available' ? 'nc-check-2' : ($material->status === 'low_stock' ? 'nc-alert-circle-i' : 'nc-simple-remove') }}"></i>
                                                    {{ ucfirst(str_replace('_', ' ', $material->status)) }}
                                                </span>
                                            </td>
                                                <td>
                                                    <span class="date-label">{{ $material->updated_at->format('M d, Y') }}</span>
                                                </td>
                                            <td>
                                                    <button class="action-btn primary" data-toggle="modal" data-target="#updateMaterialModal{{ $material->id }}">
                                                        <i class="nc-icon nc-settings-gear-65"></i>
                                                        <span>Update</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                            <div class="pagination-section">
                            {{ $materials->links() }}
                        </div>
                    @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <h5 class="empty-title">No Materials Found</h5>
                                <p class="empty-subtitle">No raw materials have been added to your inventory yet</p>
                                <div class="empty-actions">
                                    <button class="action-btn primary">
                                        <i class="nc-icon nc-simple-add"></i>
                                        <span>Add First Material</span>
                                    </button>
                                </div>
                        </div>
                    @endif
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

.material-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.material-name {
    font-weight: 600;
    color: #333;
}

.material-description {
    color: #666;
    font-style: italic;
}

.quantity-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-align: center;
    min-width: 60px;
    justify-content: center;
}

.quantity-high {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.quantity-medium {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.quantity-low {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.price-label {
    font-weight: 600;
    color: #2e7d32;
    font-size: 1rem;
}

.date-label {
    font-weight: 500;
    color: #666;
    font-size: 0.9rem;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-available {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-low_stock {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-out_of_stock {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.status-badge i {
    font-size: 12px;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.action-btn i {
    font-size: 14px;
}

/* Pagination Section */
.pagination-section {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    gap: 5px;
}

.page-link {
    padding: 8px 12px;
    border: 1px solid rgba(25, 118, 210, 0.2);
    background: rgba(255, 255, 255, 0.8);
    color: #1976d2;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: rgba(25, 118, 210, 0.1);
    border-color: #1976d2;
    color: #1976d2;
    transform: translateY(-2px);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(25, 118, 210, 0.1);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 40px;
    color: #1976d2;
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
    margin: 0 0 30px 0;
}

.empty-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
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
    
    .material-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endsection 