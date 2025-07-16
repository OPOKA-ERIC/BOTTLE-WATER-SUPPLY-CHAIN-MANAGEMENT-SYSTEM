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

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="nc-icon nc-check-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="nc-icon nc-alert-circle-i"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="nc-icon nc-alert-circle-i"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

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
                        <h3 class="stats-number">
                            UGX {{ number_format($materials->sum(function($m) { return $m->quantity_available * $m->price; }), 0) }}/=
                        </h3>
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
                        <div class="header-actions ml-auto">
                            <button class="action-btn primary" data-toggle="modal" data-target="#addMaterialModal">
                                <i class="nc-icon nc-simple-add"></i>
                                <span>Add Material</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($materials) && $materials->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Material Name</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Unit Price (UGX)</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="materials-table-body">
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
                                                    <span class="quantity-badge quantity-{{ $material->quantity_available > 100 ? 'high' : ($material->quantity_available > 50 ? 'medium' : 'low') }}">
                                                        {{ $material->quantity_available }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="unit-label">{{ $material->unit_of_measure }}</span>
                                                </td>
                                                <td>
                                                    <span class="price-label">UGX {{ number_format($material->price, 0) }}/=</span>
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
</div>

<!-- Add Material Modal -->
<div class="modal fade" id="addMaterialModal" tabindex="-1" role="dialog" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('supplier.materials.store') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addMaterialModalLabel">Add New Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Material Name</label>
            <select name="name" id="name" class="form-control" required>
                <option value="bottles">Bottles</option>
                <option value="bottle lids">Bottle Lids</option>
                <option value="boxes for packing">Boxes for Packing</option>
                <option value="water">Water</option>
                <option value="paper">Paper</option>
            </select>
          </div>
          <div class="form-group">
            <label for="material-description">Description</label>
            <textarea class="form-control" id="material-description" name="description"></textarea>
          </div>
          <div class="form-group">
            <label for="material-quantity">Quantity</label>
            <input type="number" class="form-control" id="material-quantity" name="quantity_available" min="0" required>
          </div>
          <div class="form-group">
            <label for="material-unit">Unit of Measure</label>
            <select class="form-control" id="material-unit" name="unit_of_measure" required>
              <option value="pieces">Pieces</option>
              <option value="litres">Litres</option>
              <option value="reams">Reams</option>
            </select>
          </div>
          <div class="form-group">
            <label for="material-price">Unit Price (UGX)</label>
            <input type="number" class="form-control" id="material-price" name="price" min="0" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="material-status">Status</label>
            <select class="form-control" id="material-status" name="status" required>
              <option value="available">Available</option>
              <option value="low_stock">Low Stock</option>
              <option value="unavailable">Unavailable</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Material</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Update Material Modals -->
@foreach($materials as $material)
<div class="modal fade" id="updateMaterialModal{{ $material->id }}" tabindex="-1" role="dialog" aria-labelledby="updateMaterialModalLabel{{ $material->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('supplier.materials.update', $material->id) }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateMaterialModalLabel{{ $material->id }}">Update Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="material-quantity-{{ $material->id }}">Quantity</label>
            <input type="number" class="form-control" id="material-quantity-{{ $material->id }}" name="quantity_available" value="{{ $material->quantity_available }}" min="0" required>
          </div>
          <div class="form-group">
            <label for="material-price-{{ $material->id }}">Unit Price (UGX)</label>
            <input type="number" class="form-control" id="material-price-{{ $material->id }}" name="price" value="{{ $material->price }}" min="0" step="0.01" required>
          </div>
          <div class="form-group">
            <label for="material-status-{{ $material->id }}">Status</label>
            <select class="form-control" id="material-status-{{ $material->id }}" name="status" required>
              <option value="available" {{ $material->status == 'available' ? 'selected' : '' }}>Available</option>
              <option value="low_stock" {{ $material->status == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
              <option value="unavailable" {{ $material->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Material</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach



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
    overflow-x: auto;
    overflow-y: visible;
    /* Hide scrollbar if not needed */
    scrollbar-width: thin;
    scrollbar-color: #ccc #f5f5f5;
}

.card-body::-webkit-scrollbar {
    height: 8px;
    background: #f5f5f5;
}

.card-body::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
}

/* Table Styling */
.table {
    margin: 0;
    min-width: 100%;
    width: 100%;
    table-layout: auto;
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

/* Remove all vertical and horizontal scrolling from inner containers */
.content,
.container-fluid,
.card-body,
.content-card,
.row,
.col-md-12 {
    overflow-y: visible !important;
    overflow-x: visible !important;
    max-height: none !important;
    height: auto !important;
}

/* Alert Styles */
.alert {
    border-radius: 15px;
    border: none;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
}

.alert-success {
    background: linear-gradient(135deg, rgba(76, 175, 80, 0.95) 0%, rgba(56, 142, 60, 0.95) 100%);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, rgba(244, 67, 54, 0.95) 0%, rgba(211, 47, 47, 0.95) 100%);
    color: white;
}

.alert i {
    margin-right: 10px;
    font-size: 18px;
}

.alert .close {
    color: white;
    opacity: 0.8;
}

.alert .close:hover {
    opacity: 1;
}

/* Modal Styles - Ensure proper visibility and positioning */
.modal {
    z-index: 1050 !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
}

.modal-dialog {
    z-index: 1055 !important;
    margin: 30px auto !important;
    max-width: 500px !important;
}

.modal-content {
    border-radius: 15px !important;
    border: none !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
    backdrop-filter: blur(20px) !important;
}

.modal-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%) !important;
    color: white !important;
    border-radius: 15px 15px 0 0 !important;
    border-bottom: none !important;
    padding: 20px 25px !important;
}

.modal-title {
    font-weight: 600 !important;
    font-size: 1.25rem !important;
}

.modal-header .close {
    color: white !important;
    opacity: 0.8 !important;
    text-shadow: none !important;
}

.modal-header .close:hover {
    opacity: 1 !important;
}

.modal-body {
    padding: 25px !important;
    background: white !important;
}

.modal-footer {
    background: #f8f9fa !important;
    border-top: 1px solid #dee2e6 !important;
    border-radius: 0 0 15px 15px !important;
    padding: 20px 25px !important;
}

.form-group {
    margin-bottom: 20px !important;
}

.form-group label {
    font-weight: 500 !important;
    color: #333 !important;
    margin-bottom: 8px !important;
}

.form-control {
    border-radius: 8px !important;
    border: 1px solid #ddd !important;
    padding: 12px 15px !important;
    font-size: 14px !important;
    transition: all 0.3s ease !important;
}

.form-control:focus {
    border-color: #1976d2 !important;
    box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25) !important;
}

.btn {
    border-radius: 8px !important;
    padding: 10px 20px !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
}

.btn-primary {
    background: linear-gradient(135deg, #1976d2, #1565c0) !important;
    border: none !important;
    color: white !important;
    font-weight: 600 !important;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1565c0, #0d47a1) !important;
    transform: translateY(-2px) !important;
    color: white !important;
    text-decoration: none !important;
}

.btn-secondary {
    background: linear-gradient(135deg, #2196f3, #1976d2) !important;
    border: none !important;
    color: white !important;
    font-weight: 600 !important;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #1976d2, #1565c0) !important;
    transform: translateY(-2px) !important;
    color: white !important;
    text-decoration: none !important;
}

/* Ensure modal is scrollable if content is too long */
.modal-body {
    max-height: 70vh !important;
    overflow-y: auto !important;
}

/* Fix for modal backdrop */
.modal-backdrop {
    z-index: 1040 !important;
}
</style>

<script>
function formatCurrency(amount) {
    return 'UGX ' + Number(amount).toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
}

function updateMaterialsUI(data) {
    // Update statistics cards
    document.querySelectorAll('.stats-number')[0].textContent = data.total;
    document.querySelectorAll('.stats-number')[1].textContent = data.available;
    document.querySelectorAll('.stats-number')[2].textContent = data.low_stock;
    document.querySelectorAll('.stats-number')[3].textContent = formatCurrency(
        data.materials.reduce((sum, m) => sum + (m.quantity_available * m.price), 0)
    );

    // Update materials table
    let tbody = document.getElementById('materials-table-body');
    if (tbody) {
        tbody.innerHTML = '';
        data.materials.forEach(material => {
            let quantityClass = material.quantity_available > 100 ? 'high' : (material.quantity_available > 50 ? 'medium' : 'low');
            tbody.innerHTML += `<tr>
                <td><div class='material-info'><span class='material-name'>${material.name}</span></div></td>
                <td><span class='material-description'>${material.description ? material.description.substring(0, 50) : ''}</span></td>
                <td><span class='quantity-badge quantity-${quantityClass}'>${material.quantity_available}</span></td>
                <td><span class='unit-label'>${material.unit_of_measure}</span></td>
                <td><span class='price-label'>${formatCurrency(material.price)}</span></td>
                <td><span class='status-badge status-${material.status}'><i class='nc-icon ${material.status === 'available' ? 'nc-check-2' : (material.status === 'low_stock' ? 'nc-alert-circle-i' : 'nc-simple-remove')}'></i> ${material.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}</span></td>
                <td><span class='date-label'>${new Date(material.updated_at).toLocaleDateString()}</span></td>
                <td><button class='action-btn primary' data-toggle='modal' data-target='#updateMaterialModal${material.id}'><i class='nc-icon nc-settings-gear-65'></i><span>Update</span></button></td>
            </tr>`;
        });
    }
}

function fetchMaterialsData() {
    fetch('/supplier/materials/api')
        .then(res => res.json())
        .then(data => {
            updateMaterialsUI(data);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    // Only fetch data initially, don't auto-refresh to preserve modal functionality
    // fetchMaterialsData();
    // setInterval(fetchMaterialsData, 30000);
});

document.addEventListener('DOMContentLoaded', function() {
  // Add Material button in header
  var addHeaderBtn = document.querySelector('.header-actions .action-btn.primary');
  if (addHeaderBtn) {
    addHeaderBtn.addEventListener('click', function(e) {
      e.preventDefault();
      $('#addMaterialModal').modal('show');
    });
  }
  // Add First Material button in empty state
  var addBtn = document.querySelector('.empty-actions .action-btn.primary');
  if (addBtn) {
    addBtn.setAttribute('data-toggle', 'modal');
    addBtn.setAttribute('data-target', '#addMaterialModal');
    addBtn.addEventListener('click', function(e) {
      e.preventDefault();
      $('#addMaterialModal').modal('show');
    });
  }

  // Ensure modals are properly initialized
  $('.modal').on('shown.bs.modal', function () {
    $(this).find('input:first').focus();
  });

  // Handle modal close
  $('.modal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
  });

  // Ensure modals are visible and properly positioned
  $('.modal').css({
    'display': 'none',
    'z-index': '1050'
  });

  // Fix for modal backdrop
  $('body').on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
      $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
  });
});
</script>
@endsection 