@extends('layouts.app', ['activePage' => 'production', 'title' => 'Production Batches'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Production Management</h1>
                        <p class="welcome-subtitle">Monitor and manage your production batches, track progress, and optimize manufacturing operations</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="total-batches">{{ $totalBatches ?? 0 }}</h3>
                        <p class="stats-label">Total Batches</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>All time</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-time-alarm"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="in-progress-batches">{{ $inProgressBatches ?? 0 }}</h3>
                        <p class="stats-label">In Progress</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Active production</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-check-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="completed-batches">{{ $completedBatches ?? 0 }}</h3>
                        <p class="stats-label">Completed</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Finished batches</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-box-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="total-quantity">{{ number_format($totalQuantity ?? 0) }}</h3>
                        <p class="stats-label">Total Quantity</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Units produced</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Quick Actions</h4>
                            <p class="card-subtitle">Common production tasks and operations</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <button class="quick-action-btn" data-toggle="modal" data-target="#createBatchModal">
                                <div class="action-icon">
                                    <i class="nc-icon nc-simple-add"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Create New Batch</span>
                                    <span class="action-subtitle">Start production process</span>
                                </div>
                            </button>
                            <a href="{{ route('manufacturer.inventory.index') }}" class="quick-action-btn">
                                <div class="action-icon">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <div class="action-content">
                                    <span class="action-title">Inventory Check</span>
                                    <span class="action-subtitle">Review material levels</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Production Batches Table -->
        <div class="row">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Production Batches</h4>
                            <p class="card-subtitle">Manage and monitor your production batches</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="batches-table-container">
                            @if(isset($batches) && $batches->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Batch ID</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Start Date</th>
                                                <th>Completion Date</th>
                                                <th>Progress</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="batches-tbody">
                                            @foreach($batches as $batch)
                                                <tr data-batch-id="{{ $batch->id }}">
                                                    <td><span class="batch-id">#{{ $batch->id }}</span></td>
                                                    <td><span class="product-name">{{ $batch->product->name ?? 'N/A' }}</span></td>
                                                    <td><span class="quantity">{{ number_format($batch->quantity) }}</span></td>
                                                    <td>
                                                        <span class="status-badge status-{{ $batch->status }}">
                                                            {{ ucfirst(str_replace('_', ' ', $batch->status)) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $batch->start_date ? \Carbon\Carbon::parse($batch->start_date)->format('M d, Y') : 'N/A' }}</td>
                                                    <td>{{ $batch->estimated_completion ? \Carbon\Carbon::parse($batch->estimated_completion)->format('M d, Y') : 'N/A' }}</td>
                                                    <td>
                                                        <div class="progress-container">
                                                            <div class="progress-bar">
                                                                <div class="progress-fill" style="width: {{ $batch->status === 'completed' ? '100' : ($batch->status === 'in_progress' ? '65' : '25') }}%"></div>
                                                            </div>
                                                            <span class="progress-text">{{ $batch->status === 'completed' ? '100' : ($batch->status === 'in_progress' ? '65' : '25') }}%</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button class="action-btn primary" title="View Details" onclick="viewBatchDetails({{ $batch->id }})">
                                                                <i class="nc-icon nc-zoom-split-in"></i>
                                                                <span>View</span>
                                                            </button>
                                                            @if($batch->status === 'pending')
                                                            <button class="action-btn secondary" title="Start Production" onclick="updateBatchStatus({{ $batch->id }}, 'in_progress')">
                                                                <i class="nc-icon nc-settings-gear-65"></i>
                                                                <span>Start</span>
                                                            </button>
                                                            <button class="action-btn warning" title="Edit Batch" onclick="editBatch({{ $batch->id }})">
                                                                <i class="nc-icon nc-ruler-pencil"></i>
                                                                <span>Edit</span>
                                                            </button>
                                                            @endif
                                                            @if($batch->status === 'in_progress')
                                                            <button class="action-btn success" title="Mark Complete" onclick="updateBatchStatus({{ $batch->id }}, 'completed')">
                                                                <i class="nc-icon nc-check-2"></i>
                                                                <span>Complete</span>
                                                            </button>
                                                            <button class="action-btn warning" title="Edit Batch" onclick="editBatch({{ $batch->id }})">
                                                                <i class="nc-icon nc-ruler-pencil"></i>
                                                                <span>Edit</span>
                                                            </button>
                                                            @endif
                                                            @if($batch->status === 'completed')
                                                            {{-- <button class="action-btn info" title="View Report" onclick="viewBatchReport({{ $batch->id }})">
                                                                <i class="nc-icon nc-chart-bar-32"></i>
                                                                <span>Report</span>
                                                            </button> --}}
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                @if($batches->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    <nav aria-label="Production batches pagination">
                                        <ul class="pagination pagination-sm mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($batches->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">‹</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $batches->previousPageUrl() }}">‹</a>
                                                </li>
                                            @endif
                                            {{-- Pagination Elements --}}
                                            @foreach ($batches->getUrlRange(1, $batches->lastPage()) as $page => $url)
                                                @if ($page == $batches->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                            {{-- Next Page Link --}}
                                            @if ($batches->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $batches->nextPageUrl() }}">›</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">›</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                                @endif
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="nc-icon nc-settings-gear-65"></i>
                                    </div>
                                    <h4 class="empty-title">No Production Batches Found</h4>
                                    <p class="empty-subtitle">No production batches have been created yet. Start by creating your first batch.</p>
                                    <button class="empty-action-btn" data-toggle="modal" data-target="#createBatchModal">
                                        <i class="nc-icon nc-simple-add"></i>
                                        <span>Create First Batch</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Batch Modal -->
<div class="modal fade" id="createBatchModal" tabindex="-1" role="dialog" aria-labelledby="createBatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBatchModalLabel">Create New Production Batch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createBatchForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required min="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estimated_completion">Estimated Completion</label>
                                <input type="date" class="form-control" id="estimated_completion" name="estimated_completion" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes about this batch"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="createBatchBtn" onclick="createBatch()">
                    <span class="btn-text">Create Batch</span>
                    <span class="btn-loading d-none">
                        <i class="nc-icon nc-refresh-69 fa-spin"></i>
                        Creating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Batch Modal -->
<div class="modal fade" id="editBatchModal" tabindex="-1" role="dialog" aria-labelledby="editBatchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBatchModalLabel">Edit Production Batch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editBatchForm">
                    @csrf
                    <input type="hidden" id="edit_batch_id" name="batch_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_quantity">Quantity</label>
                                <input type="number" class="form-control" id="edit_quantity" name="quantity" required min="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_estimated_completion">Estimated Completion</label>
                                <input type="date" class="form-control" id="edit_estimated_completion" name="estimated_completion" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_notes">Notes</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveEditBatchBtn" onclick="saveEditBatch()">
                    <span class="btn-text">Save Changes</span>
                    <span class="btn-loading d-none">
                        <i class="nc-icon nc-refresh-69 fa-spin"></i>
                        Saving...
                    </span>
                </button>
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

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
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
    cursor: pointer;
    border: none;
    width: 100%;
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

/* Progress Bar */
.progress-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    min-width: 35px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: nowrap;
    overflow-x: auto;
}

.action-btn {
    padding: 6px 12px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.action-btn.secondary {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    border: 1px solid rgba(108, 117, 125, 0.2);
}

.action-btn.secondary:hover {
    background: rgba(108, 117, 125, 0.2);
    transform: translateY(-2px);
}

.action-btn.success {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
    border: 1px solid rgba(39, 174, 96, 0.2);
}

.action-btn.success:hover {
    background: rgba(39, 174, 96, 0.2);
    transform: translateY(-2px);
}

.action-btn.warning {
    background: rgba(243, 156, 18, 0.1);
    color: #f39c12;
    border: 1px solid rgba(243, 156, 18, 0.2);
}

.action-btn.warning:hover {
    background: rgba(243, 156, 18, 0.2);
    transform: translateY(-2px);
}

.action-btn.info {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
    border: 1px solid rgba(23, 162, 184, 0.2);
}

.action-btn.info:hover {
    background: rgba(23, 162, 184, 0.2);
    transform: translateY(-2px);
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.empty-subtitle {
    color: #7f8c8d;
    margin-bottom: 30px;
    font-size: 1rem;
}

.empty-action-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0 auto;
}

.empty-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

/* Modal Styling */
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    border-bottom: none;
}

.modal-title {
    font-weight: 600;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
}

.modal-header .close:hover {
    opacity: 1;
}

.modal-body {
    padding: 30px;
}

.form-group label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #e9ecef;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 20px 30px;
}

.btn {
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .action-btn {
        justify-content: center;
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
    
    .modal-dialog {
        margin: 10px;
    }
}

/* Loading States */
.btn-loading {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.d-none {
    display: none !important;
}

/* Form Validation Styling */
.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

/* Success/Error States */
.form-control.is-valid {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.valid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #28a745;
}

/* Make table cells and headers not wrap and fit in one line */
.table th,
.table td {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Ensure action buttons stay in a single row and do not wrap */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: nowrap;
    overflow-x: auto;
}

/* If the table is too wide, allow horizontal scrolling */
.table-responsive {
    overflow-x: auto;
}
</style>

<script>
// Global variables
let isCreatingBatch = false;

// Initialize when document is ready
$(document).ready(function() {
    console.log('Document ready, initializing production batches page');
    
    // Set default dates for the form
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date(Date.now() + 24*60*60*1000).toISOString().split('T')[0];
    
    console.log('Setting default dates:', {today: today, tomorrow: tomorrow});
    
    $('#start_date').val(today);
    $('#estimated_completion').val(tomorrow);
    
    // Check if CSRF token is available
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log('CSRF token available:', !!csrfToken);
    console.log('CSRF token value:', csrfToken);
    
    // Check if products are loaded
    const productSelect = $('#product_id');
    console.log('Products loaded:', productSelect.find('option').length - 1); // -1 for the default option
    
    // Log the route URL
    console.log('Production batch creation route:', '{{ route("manufacturer.production.batches.store") }}');
    
    // Check if action buttons exist
    const actionButtons = $('.action-btn');
    console.log('Action buttons found:', actionButtons.length);
    
    // Check if batches table exists
    const batchesTable = $('#batches-tbody');
    console.log('Batches table found:', batchesTable.length);
    console.log('Batches table rows:', batchesTable.find('tr').length);
    
    // Auto-refresh data every 30 seconds
    setInterval(refreshBatchesData, 30000);
    
    console.log('Production batches page initialized successfully');
});

// Create new production batch
function createBatch() {
    console.log('createBatch function called');
    
    if (isCreatingBatch) {
        console.log('Already creating batch, returning');
        return;
    }
    
    const form = $('#createBatchForm')[0];
    const formData = new FormData(form);
    
    // Debug: Log form data
    console.log('Form data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Validate form
    if (!form.checkValidity()) {
        console.log('Form validation failed');
        console.log('Form validity:', form.validity);
        console.log('Form validationMessage:', form.validationMessage);
        form.reportValidity();
        return;
    }
    
    console.log('Form validation passed');
    console.log('Form is valid:', form.checkValidity());
    
    isCreatingBatch = true;
    const btn = $('#createBatchBtn');
    const btnText = btn.find('.btn-text');
    const btnLoading = btn.find('.btn-loading');
    
    // Show loading state
    btnText.addClass('d-none');
    btnLoading.removeClass('d-none');
    btn.prop('disabled', true);
    
    console.log('Making AJAX request to:', '{{ route("manufacturer.production.batches.store") }}');
    console.log('AJAX request details:', {
        url: '{{ route("manufacturer.production.batches.store") }}',
        type: 'POST',
        processData: false,
        contentType: false,
        hasFormData: formData instanceof FormData,
        formDataEntries: Array.from(formData.entries())
    });
    
    $.ajax({
        url: '{{ route("manufacturer.production.batches.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            console.log('AJAX request beforeSend called');
            console.log('Request headers:', xhr.getAllResponseHeaders());
        },
        success: function(response) {
            console.log('AJAX success response:', response);
            if (response.success) {
                // Show success message
                showNotification('success', 'Success', response.message || 'Production batch created successfully');
                $('#createBatchModal').modal('hide');
                form.reset();
                refreshBatchesData();
            } else {
                showNotification('danger', 'Error', response.message || 'Failed to create batch');
                console.error('Failed to create batch:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX error:', {xhr: xhr, status: status, error: error});
            console.log('Response text:', xhr.responseText);
            console.log('Response status:', xhr.status);
            console.log('Response status text:', xhr.statusText);
            console.log('Response headers:', xhr.getAllResponseHeaders());
            
            let errorMessage = 'Failed to create batch';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            } else if (xhr.status === 404) {
                errorMessage = 'Route not found. Please refresh the page.';
            }
            
            showNotification('danger', 'Error', errorMessage);
            console.error('AJAX Error:', xhr.status, xhr.statusText, xhr.responseText);
        },
        complete: function() {
            console.log('AJAX request completed');
            // Reset button state
            btnText.removeClass('d-none');
            btnLoading.addClass('d-none');
            btn.prop('disabled', false);
            isCreatingBatch = false;
        }
    });
}

// Helper function to show notifications
function showNotification(type, title, message) {
    $.notify({
        icon: type === 'success' ? 'nc-icon nc-check-2' : 'nc-icon nc-alert-circle-i',
        title: title,
        message: message
    }, {
        type: type,
        timer: 5000,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
}

// Update batch status
function updateBatchStatus(batchId, newStatus) {
    console.log('updateBatchStatus called with:', { batchId, newStatus });
    
    const statusText = newStatus.replace('_', ' ');
    const confirmMessage = `Are you sure you want to mark this batch as ${statusText}?`;
    
    if (!confirm(confirmMessage)) {
        console.log('User cancelled status update');
        return;
    }
    
    console.log('Making AJAX request to update batch status...');
    
    // Debug: Show the actual URL being generated
    const routeUrl = `{{ route('manufacturer.production.batches.status', ':id') }}`.replace(':id', batchId);
    console.log('Generated route URL:', routeUrl);
    
    $.ajax({
        url: routeUrl,
        type: 'POST',
        data: {
            status: newStatus,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            console.log('AJAX request beforeSend for status update');
            console.log('Request URL:', this.url);
            console.log('Request data:', this.data);
        },
        success: function(response) {
            console.log('Status update success response:', response);
            if (response.success) {
                showNotification('success', 'Success', response.message || 'Batch status updated successfully');
                refreshBatchesData();
            } else {
                showNotification('danger', 'Error', response.message || 'Failed to update batch status');
                console.error('Failed to update batch status:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('Status update AJAX error:', { xhr, status, error });
            console.log('Response text:', xhr.responseText);
            console.log('Response status:', xhr.status);
            
            let errorMessage = 'Failed to update batch status';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            } else if (xhr.status === 404) {
                errorMessage = 'Batch not found. Please refresh the page.';
            }
            
            showNotification('danger', 'Error', errorMessage);
            console.error('AJAX Error:', xhr.status, xhr.statusText, xhr.responseText);
        }
    });
}

// Refresh batches data
function refreshBatchesData() {
    const btn = document.getElementById('refreshDataBtn');
    if (btn) btn.classList.add('loading');
    $.ajax({
        url: '{{ route("manufacturer.production.batches.data") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                updateStats(response.stats);
                updateBatchesTable(response.batches);
            } else {
                showNotification('danger', 'Error', response.message || 'Failed to refresh data');
                console.error('Failed to refresh data:', response.message);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to refresh data';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            } else if (xhr.status === 404) {
                errorMessage = 'Data endpoint not found. Please refresh the page.';
            }
            
            showNotification('danger', 'Error', errorMessage);
            console.error('Failed to refresh data:', xhr.status, xhr.statusText);
        },
        complete: function() {
            if (btn) btn.classList.remove('loading');
        }
    });
}

// Update statistics
function updateStats(stats) {
    $('#total-batches').text(stats.total_batches);
    $('#in-progress-batches').text(stats.in_progress);
    $('#completed-batches').text(stats.completed);
    $('#total-quantity').text(stats.total_quantity.toLocaleString());
}

// Update batches table
function updateBatchesTable(batches) {
    const tbody = $('#batches-tbody');
    const container = $('#batches-table-container');
    
    if (batches.length === 0) {
        container.html(`
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="nc-icon nc-settings-gear-65"></i>
                </div>
                <h4 class="empty-title">No Production Batches Found</h4>
                <p class="empty-subtitle">No production batches have been created yet. Start by creating your first batch.</p>
                <button class="empty-action-btn" data-toggle="modal" data-target="#createBatchModal">
                    <i class="nc-icon nc-simple-add"></i>
                    <span>Create First Batch</span>
                </button>
            </div>
        `);
        return;
    }
    
    let tableHtml = `
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Batch ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>Completion Date</th>
                        <th>Progress</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="batches-tbody">
    `;
    
    batches.forEach(function(batch) {
        const startDate = batch.production_date ? new Date(batch.production_date).toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric' 
        }) : 'N/A';
        
        const completionDate = batch.estimated_completion ? new Date(batch.estimated_completion).toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric' 
        }) : 'N/A';
        
        const progressPercent = batch.status === 'completed' ? '100' : 
                               batch.status === 'in_progress' ? '65' : '25';
        
        let actionButtons = `
            <button class="action-btn primary" title="View Details" onclick="viewBatchDetails(${batch.id})">
                <i class="nc-icon nc-zoom-split-in"></i>
                <span>View</span>
            </button>
        `;
        
        if (batch.status === 'pending') {
            actionButtons += `
                <button class="action-btn secondary" title="Start Production" onclick="updateBatchStatus(${batch.id}, 'in_progress')">
                    <i class="nc-icon nc-settings-gear-65"></i>
                    <span>Start</span>
                </button>
                <button class="action-btn warning" title="Edit Batch" onclick="editBatch(${batch.id})">
                    <i class="nc-icon nc-ruler-pencil"></i>
                    <span>Edit</span>
                </button>
            `;
        } else if (batch.status === 'in_progress') {
            actionButtons += `
                <button class="action-btn success" title="Mark Complete" onclick="updateBatchStatus(${batch.id}, 'completed')">
                    <i class="nc-icon nc-check-2"></i>
                    <span>Complete</span>
                </button>
                <button class="action-btn warning" title="Edit Batch" onclick="editBatch(${batch.id})">
                    <i class="nc-icon nc-ruler-pencil"></i>
                    <span>Edit</span>
                </button>
            `;
        } else if (batch.status === 'completed') {
            // Do not add the Report button for completed batches
        }
        
        tableHtml += `
            <tr data-batch-id="${batch.id}">
                <td><span class="batch-id">#${batch.id}</span></td>
                <td><span class="product-name">${batch.product ? batch.product.name : 'N/A'}</span></td>
                <td><span class="quantity">${batch.quantity.toLocaleString()}</span></td>
                <td>
                    <span class="status-badge status-${batch.status}">
                        ${batch.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                    </span>
                </td>
                <td>${startDate}</td>
                <td>${completionDate}</td>
                <td>
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${progressPercent}%"></div>
                        </div>
                        <span class="progress-text">${progressPercent}%</span>
                    </div>
                </td>
                <td>
                    <div class="action-buttons">
                        ${actionButtons}
                    </div>
                </td>
            </tr>
        `;
    });
    
    tableHtml += `
                </tbody>
            </table>
        </div>
    `;
    
    container.html(tableHtml);
}

// View batch details
function viewBatchDetails(batchId) {
    console.log('viewBatchDetails called with batchId:', batchId);
    
    $.ajax({
        url: `{{ route('manufacturer.production.batches.details', ':id') }}`.replace(':id', batchId),
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            console.log('AJAX request beforeSend for view details');
            console.log('Request URL:', this.url);
        },
        success: function(response) {
            console.log('View details success response:', response);
            if (response.success) {
                const batch = response.batch;
                const startDate = batch.start_date ? new Date(batch.start_date).toLocaleDateString('en-US', { 
                    month: 'long', 
                    day: 'numeric', 
                    year: 'numeric' 
                }) : 'N/A';
                
                const estimatedCompletion = batch.estimated_completion ? new Date(batch.estimated_completion).toLocaleDateString('en-US', { 
                    month: 'long', 
                    day: 'numeric', 
                    year: 'numeric' 
                }) : 'N/A';
                
                const actualCompletion = batch.completed_at ? new Date(batch.completed_at).toLocaleDateString('en-US', { 
                    month: 'long', 
                    day: 'numeric', 
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : 'N/A';
                
                const details = `
PRODUCTION BATCH DETAILS

BATCH INFORMATION:
• Batch ID: #${batch.id}
• Product: ${batch.product ? batch.product.name : 'N/A'}
• Quantity: ${batch.quantity.toLocaleString()} units
• Status: ${batch.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}

DATES:
• Start Date: ${startDate}
• Estimated Completion: ${estimatedCompletion}
• Actual Completion: ${actualCompletion}

NOTES:
${batch.notes || 'No additional notes provided'}

Created: ${new Date(batch.created_at).toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
})}
                `;
                alert(details);
            } else {
                showNotification('danger', 'Error', response.message || 'Failed to load batch details');
            }
        },
        error: function(xhr, status, error) {
            console.log('View details AJAX error:', { xhr, status, error });
            console.log('Response text:', xhr.responseText);
            console.log('Response status:', xhr.status);
            
            let errorMessage = 'Failed to load batch details';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Batch not found.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            
            showNotification('danger', 'Error', errorMessage);
            console.error('Failed to load batch details:', xhr.status, xhr.statusText);
        }
    });
}

// Edit batch
function editBatch(batchId) {
    console.log('editBatch called with batchId:', batchId);
    
    // Fetch batch details and fill the modal
    $.ajax({
        url: `{{ route('manufacturer.production.batches.details', ':id') }}`.replace(':id', batchId),
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            console.log('AJAX request beforeSend for edit batch');
            console.log('Request URL:', this.url);
        },
        success: function(response) {
            console.log('Edit batch success response:', response);
            if (response.success) {
                const batch = response.batch;
                $('#edit_batch_id').val(batch.id);
                $('#edit_quantity').val(batch.quantity);
                $('#edit_estimated_completion').val(batch.estimated_completion ? batch.estimated_completion.substring(0, 10) : '');
                $('#edit_notes').val(batch.notes || '');
                $('#editBatchModal').modal('show');
            } else {
                showNotification('danger', 'Error', response.message || 'Failed to load batch details');
            }
        },
        error: function(xhr, status, error) {
            console.log('Edit batch AJAX error:', { xhr, status, error });
            console.log('Response text:', xhr.responseText);
            console.log('Response status:', xhr.status);
            
            let errorMessage = 'Failed to load batch details';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 404) {
                errorMessage = 'Batch not found.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            
            showNotification('danger', 'Error', errorMessage);
            console.error('Failed to load batch details:', xhr.status, xhr.statusText);
        }
    });
}

// Save edited batch
function saveEditBatch() {
    const form = $('#editBatchForm')[0];
    const formData = new FormData(form);
    const batchId = $('#edit_batch_id').val();
    
    // Add _method field for PUT request
    formData.append('_method', 'PUT');
    
    // Debug: Log form data
    console.log('Form data being sent:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const btn = $('#saveEditBatchBtn');
    const btnText = btn.find('.btn-text');
    const btnLoading = btn.find('.btn-loading');
    
    // Show loading state
    btnText.addClass('d-none');
    btnLoading.removeClass('d-none');
    btn.prop('disabled', true);
    
    $.ajax({
        url: `{{ route('manufacturer.production.batches.update', ':id') }}`.replace(':id', batchId),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(xhr) {
            console.log('AJAX request beforeSend for save edit batch');
            console.log('Request URL:', this.url);
            console.log('Request type:', this.type);
        },
        success: function(response) {
            console.log('Save edit batch success response:', response);
            if (response.success) {
                showNotification('success', 'Success', response.message || 'Batch updated successfully');
                $('#editBatchModal').modal('hide');
                refreshBatchesData();
            } else {
                showNotification('danger', 'Error', response.message || 'Failed to update batch');
                console.error('Failed to update batch:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('Save edit batch AJAX error:', { xhr, status, error });
            console.log('Response text:', xhr.responseText);
            console.log('Response status:', xhr.status);
            
            let errorMessage = 'Failed to update batch';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
            } else if (xhr.status === 422) {
                errorMessage = 'Validation error. Please check your input.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            } else if (xhr.status === 404) {
                errorMessage = 'Batch not found. Please refresh the page.';
            }
            
            showNotification('danger', 'Error', errorMessage);
            console.error('AJAX Error:', xhr.status, xhr.statusText, xhr.responseText);
        },
        complete: function() {
            btnText.removeClass('d-none');
            btnLoading.addClass('d-none');
            btn.prop('disabled', false);
        }
    });
}

// View batch report
function viewBatchReport(batchId) {
    // For now, show a simple message
    // This can be expanded to show a detailed report modal later
    alert(`Production Report for batch #${batchId} will be implemented soon.\n\nThis will show:\n• Production efficiency metrics\n• Time analysis\n• Cost breakdown\n• Quality metrics\n• Performance indicators`);
}

// Handle modal events
$('#createBatchModal').on('show.bs.modal', function() {
    console.log('Create batch modal is showing');
});

$('#createBatchModal').on('shown.bs.modal', function() {
    console.log('Create batch modal is shown');
    
    // Debug form field values
    console.log('Form field values:');
    console.log('Product ID:', $('#product_id').val());
    console.log('Quantity:', $('#quantity').val());
    console.log('Start Date:', $('#start_date').val());
    console.log('Estimated Completion:', $('#estimated_completion').val());
    console.log('Notes:', $('#notes').val());
    
    // Check if form has CSRF token
    const csrfInput = $('#createBatchForm input[name="_token"]');
    console.log('CSRF input exists:', csrfInput.length > 0);
    if (csrfInput.length > 0) {
        console.log('CSRF token value:', csrfInput.val());
    }
});

$('#createBatchModal').on('hidden.bs.modal', function() {
    console.log('Create batch modal is hidden');
    const form = $('#createBatchForm')[0];
    form.reset();
    
    // Reset button state
    const btn = $('#createBatchBtn');
    btn.find('.btn-text').removeClass('d-none');
    btn.find('.btn-loading').addClass('d-none');
    btn.prop('disabled', false);
    isCreatingBatch = false;
});

$('#editBatchModal').on('hidden.bs.modal', function() {
    console.log('Edit batch modal is hidden');
    $('#editBatchForm')[0].reset();
    const btn = $('#saveEditBatchBtn');
    btn.find('.btn-text').removeClass('d-none');
    btn.find('.btn-loading').addClass('d-none');
    btn.prop('disabled', false);
});
</script>
@endsection 