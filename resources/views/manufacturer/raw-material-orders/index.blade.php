@extends('layouts.app', ['activePage' => 'raw-material-orders', 'title' => 'Raw Material Orders'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Raw Material Orders</h1>
                        <p class="welcome-subtitle">Place orders for raw materials from suppliers to maintain your production</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-cart-simple"></i>
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

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $myOrders->total() }}</h3>
                        <p class="stats-label">Total Orders</p>
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
                        <h3 class="stats-number">{{ $myOrders->where('status', 'pending')->count() }}</h3>
                        <p class="stats-label">Pending Orders</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Awaiting confirmation</span>
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
                        <h3 class="stats-number">{{ $myOrders->where('status', 'completed')->count() }}</h3>
                        <p class="stats-label">Completed Orders</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Successfully delivered</span>
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
                        <h3 class="stats-number">UGX {{ number_format($myOrders->sum('total_amount'), 0) }}/=</h3>
                        <p class="stats-label">Total Spent</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>On raw materials</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Place New Order Section -->
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Place New Order</h4>
                            <p class="card-subtitle">Select supplier and materials to place an order</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('manufacturer.raw-material-orders.store') }}" id="orderForm">
                            @csrf
                            
                            <!-- Supplier Selection -->
                            <div class="form-group">
                                <label for="supplier_id">Select Supplier</label>
                                <select class="form-control" id="supplier_id" name="supplier_id" required>
                                    <option value="">Choose a supplier...</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }} ({{ $supplier->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Materials Selection -->
                            <div id="materials-section" style="display: none;">
                                <h5 class="mb-3">Available Materials</h5>
                                <div id="materials-list">
                                    <!-- Materials will be loaded here dynamically -->
                                </div>
                            </div>

                            <!-- Delivery Date -->
                            <div class="form-group">
                                <label for="delivery_date">Expected Delivery Date</label>
                                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>

                            <!-- Notes -->
                            <div class="form-group">
                                <label for="notes">Order Notes (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any special requirements or notes..."></textarea>
                            </div>

                            <!-- Order Summary -->
                            <div id="order-summary" style="display: none;">
                                <div class="order-summary-card">
                                    <h6 class="summary-title">Order Summary</h6>
                                    <div id="summary-items"></div>
                                    <div class="summary-total">
                                        <strong>Total: UGX <span id="total-amount">0</span>/=</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="place-order-btn" disabled>
                                    <i class="nc-icon nc-cart-simple"></i>
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- My Orders Section -->
            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">My Orders</h4>
                            <p class="card-subtitle">Recent raw material orders</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-time-alarm"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($myOrders->count() > 0)
                            <div class="orders-list">
                                @foreach($myOrders->take(5) as $order)
                                    <div class="order-item">
                                        <div class="order-header">
                                            <div class="order-supplier">{{ $order->supplier->name ?? 'Unknown Supplier' }}</div>
                                            <div class="order-status status-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </div>
                                        </div>
                                        <div class="order-details">
                                            <div class="order-amount">UGX {{ number_format($order->total_amount, 0) }}/=</div>
                                            <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <div class="order-actions">
                                            <a href="{{ route('manufacturer.raw-material-orders.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if($myOrders->count() > 5)
                                <div class="text-center mt-3">
                                    <a href="#" class="btn btn-outline-primary">View All Orders</a>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-cart-simple"></i>
                                </div>
                                <h5 class="empty-title">No Orders Yet</h5>
                                <p class="empty-subtitle">You haven't placed any raw material orders yet</p>
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

/* Form Styles */
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

.form-control {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 12px 15px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #1976d2;
    box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
}

/* Materials List */
.material-item {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 15px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.material-item:hover {
    border-color: #1976d2;
    background: #fff;
}

.material-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.material-name {
    font-weight: 600;
    color: #333;
    font-size: 1.1rem;
}

.material-price {
    color: #1976d2;
    font-weight: 600;
}

.material-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 15px;
}

.material-detail {
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

.material-quantity {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-input {
    width: 100px;
    text-align: center;
}

/* Order Summary */
.order-summary-card {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 20px;
    margin: 20px 0;
    border: 2px solid #e9ecef;
}

.summary-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
    text-align: center;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #dee2e6;
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-total {
    text-align: right;
    padding-top: 15px;
    border-top: 2px solid #dee2e6;
    margin-top: 15px;
    font-size: 1.1rem;
    color: #1976d2;
}

/* Orders List */
.orders-list {
    max-height: 400px;
    overflow-y: auto;
}

.order-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.order-item:hover {
    background: #fff;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.order-supplier {
    font-weight: 600;
    color: #333;
}

.order-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-processing {
    background: #cce5ff;
    color: #004085;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.order-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.order-amount {
    font-weight: 600;
    color: #1976d2;
}

.order-date {
    color: #666;
    font-size: 0.9rem;
}

.order-actions {
    text-align: right;
}

/* Buttons */
.btn {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.btn-primary {
    background: linear-gradient(135deg, #1976d2, #1565c0);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1565c0, #0d47a1);
    transform: translateY(-2px);
    color: white;
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
}

.btn-sm {
    padding: 8px 16px;
    font-size: 0.9rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
}

.empty-icon {
    width: 60px;
    height: 60px;
    background: rgba(25, 118, 210, 0.1);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 30px;
    color: #1976d2;
}

.empty-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
}

.empty-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin: 0;
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
    
    .material-details {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const supplierSelect = document.getElementById('supplier_id');
    const materialsSection = document.getElementById('materials-section');
    const materialsList = document.getElementById('materials-list');
    const orderSummary = document.getElementById('order-summary');
    const summaryItems = document.getElementById('summary-items');
    const totalAmount = document.getElementById('total-amount');
    const placeOrderBtn = document.getElementById('place-order-btn');
    
    const rawMaterials = @json($rawMaterials);
    
    supplierSelect.addEventListener('change', function() {
        const supplierId = this.value;
        
        if (supplierId) {
            loadMaterials(supplierId);
            materialsSection.style.display = 'block';
        } else {
            materialsSection.style.display = 'none';
            orderSummary.style.display = 'none';
            placeOrderBtn.disabled = true;
        }
    });
    
    function loadMaterials(supplierId) {
        const materials = rawMaterials[supplierId] || [];
        
        if (materials.length === 0) {
            materialsList.innerHTML = '<div class="alert alert-info">No materials available from this supplier.</div>';
            return;
        }
        
        let html = '';
        materials.forEach(material => {
            html += `
                <div class="material-item">
                    <div class="material-header">
                        <div class="material-name">${material.name}</div>
                        <div class="material-price">UGX ${Number(material.price).toLocaleString()}/=</div>
                    </div>
                    <div class="material-details">
                        <div class="material-detail">
                            <span class="detail-label">Available:</span>
                            <span class="detail-value">${material.quantity_available} ${material.unit_of_measure}</span>
                        </div>
                        <div class="material-detail">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">${material.status.replace('_', ' ')}</span>
                        </div>
                    </div>
                    <div class="material-quantity">
                        <label for="quantity_${material.id}">Order Quantity:</label>
                        <input type="number" 
                               class="form-control quantity-input" 
                               id="quantity_${material.id}" 
                               name="materials[${material.id}][quantity]" 
                               min="1" 
                               max="${material.quantity_available}"
                               value="0"
                               data-material-id="${material.id}"
                               data-material-name="${material.name}"
                               data-material-price="${material.price}"
                               onchange="updateOrderSummary()">
                        <span class="detail-value">${material.unit_of_measure}</span>
                        <input type="hidden" name="materials[${material.id}][material_id]" value="${material.id}">
                    </div>
                </div>
            `;
        });
        
        materialsList.innerHTML = html;
    }
    
    window.updateOrderSummary = function() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        let total = 0;
        let items = [];
        
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value) || 0;
            if (quantity > 0) {
                const materialId = input.dataset.materialId;
                const materialName = input.dataset.materialName;
                const materialPrice = parseFloat(input.dataset.materialPrice);
                const itemTotal = quantity * materialPrice;
                
                total += itemTotal;
                items.push({
                    name: materialName,
                    quantity: quantity,
                    price: materialPrice,
                    total: itemTotal
                });
            }
        });
        
        if (items.length > 0) {
            let summaryHtml = '';
            items.forEach(item => {
                summaryHtml += `
                    <div class="summary-item">
                        <span>${item.name} (${item.quantity})</span>
                        <span>UGX ${item.total.toLocaleString()}/=</span>
                    </div>
                `;
            });
            
            summaryItems.innerHTML = summaryHtml;
            totalAmount.textContent = total.toLocaleString();
            orderSummary.style.display = 'block';
            placeOrderBtn.disabled = false;
        } else {
            orderSummary.style.display = 'none';
            placeOrderBtn.disabled = true;
        }
    };
    
    // Form validation
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        const supplierId = supplierSelect.value;
        const deliveryDate = document.getElementById('delivery_date').value;
        
        if (!supplierId) {
            e.preventDefault();
            alert('Please select a supplier');
            return;
        }
        
        if (!deliveryDate) {
            e.preventDefault();
            alert('Please select a delivery date');
            return;
        }
        
        const hasItems = Array.from(document.querySelectorAll('.quantity-input')).some(input => {
            return parseInt(input.value) > 0;
        });
        
        if (!hasItems) {
            e.preventDefault();
            alert('Please select at least one material to order');
            return;
        }
    });
});
</script>
@endsection 