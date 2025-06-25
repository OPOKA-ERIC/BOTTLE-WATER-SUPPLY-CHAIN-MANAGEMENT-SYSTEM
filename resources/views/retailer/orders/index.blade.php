@extends('layouts.app', ['activePage' => 'orders', 'title' => 'Retailer Orders'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header-card">
                    <div class="header-content">
                        <h1 class="page-title">My Orders</h1>
                        <p class="page-subtitle">Manage and track your product orders</p>
                    </div>
                    <div class="header-actions">
                        <button class="create-order-btn" data-toggle="modal" data-target="#createOrderModal">
                            <i class="nc-icon nc-simple-add"></i>
                            <span>Create Order</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Content -->
        <div class="row">
            <div class="col-12">
                <div class="orders-card">
                    @if($orders->count() > 0)
                        <div class="card-header">
                            <div class="header-content">
                                <h4 class="card-title">Order History</h4>
                                <p class="card-subtitle">Your complete order history and status</p>
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
                                        <th>Products</th>
                                        <th>Total Quantity</th>
                                        <th>Status</th>
                                        <th>Order Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                            <tr class="order-row">
                                                <td><span class="order-id">#{{ $order->id }}</span></td>
                                            <td>
                                                    <div class="products-list">
                                                @foreach($order->products as $product)
                                                            <span class="product-badge">{{ $product->name }} ({{ $product->pivot->quantity }})</span>
                                                @endforeach
                                                    </div>
                                            </td>
                                                <td><span class="quantity-badge">{{ $order->products->sum('pivot.quantity') }}</span></td>
                                            <td>
                                                    <span class="status-badge status-{{ $order->status }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                                <td><span class="date-text">{{ $order->created_at->format('M d, Y') }}</span></td>
                                            <td>
                                                    <a href="{{ route('retailer.orders.track', $order->id) }}" class="action-btn">
                                                        <i class="nc-icon nc-chart-bar-32"></i>
                                                        <span>Track</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                            <div class="pagination-container">
                            {{ $orders->links() }}
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="nc-icon nc-cart-simple"></i>
                            </div>
                            <h3 class="empty-title">No Orders Found</h3>
                            <p class="empty-subtitle">You haven't placed any orders yet. Start by creating your first order!</p>
                            <button class="create-order-btn" data-toggle="modal" data-target="#createOrderModal">
                                <i class="nc-icon nc-simple-add"></i>
                                <span>Create Your First Order</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Order Modal -->
<div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrderModalLabel">Create New Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('retailer.orders.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="delivery_address">Delivery Address</label>
                        <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="delivery_date">Delivery Date</label>
                        <input type="date" class="form-control" id="delivery_date" name="delivery_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                    <div class="form-group">
                        <label>Products</label>
                        <div id="products-container">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <select class="form-control" name="products[0][id]" required>
                                        <option value="">Select Product</option>
                                        <!-- Add your products here -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="products[0][quantity]" placeholder="Quantity" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-danger remove-product">Remove</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-success" id="add-product">
                            <i class="nc-icon nc-simple-add"></i> Add Product
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Content spacing to account for fixed navbar */
.content {
    padding-top: 100px !important;
    margin-top: 0;
}

/* Page Header */
.page-header-card {
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

.header-content {
    flex: 1;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.page-subtitle {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.9;
    font-weight: 400;
}

.header-actions {
    display: flex;
    align-items: center;
}

.create-order-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.create-order-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
}

.create-order-btn i {
    font-size: 18px;
}

/* Orders Card */
.orders-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-height: 400px;
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

.order-row {
    transition: all 0.3s ease;
}

.order-row:hover {
    background: rgba(25, 118, 210, 0.05);
    transform: translateX(5px);
}

.order-id {
    font-weight: 600;
    color: #1976d2;
    font-size: 1.1rem;
}

.products-list {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.product-badge {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
}

.quantity-badge {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
}

.date-text {
    color: #666;
    font-size: 0.9rem;
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

.status-pending {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-delivered {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-processing {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

.status-cancelled {
    background: rgba(211, 47, 47, 0.1);
    color: #d32f2f;
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

/* Pagination */
.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    border: none;
    color: #1976d2;
    padding: 10px 15px;
    margin: 0 2px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 30px;
    color: #666;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.1), rgba(13, 71, 161, 0.1));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
}

.empty-icon i {
    font-size: 40px;
    color: #1976d2;
}

.empty-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 15px 0;
}

.empty-subtitle {
    font-size: 1.1rem;
    color: #666;
    margin: 0 0 30px 0;
    line-height: 1.5;
}

/* Modal Styling */
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    border: none;
}

.modal-title {
    font-weight: 700;
}

.modal-body {
    padding: 30px;
}

.form-control {
    border-radius: 8px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #1976d2;
    box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        padding-top: 120px !important;
    }
    
    .page-header-card {
        flex-direction: column;
        text-align: center;
        gap: 20px;
        padding: 30px 20px;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .header-icon {
        margin: 0;
    }
    
    .products-list {
        flex-direction: column;
        gap: 3px;
    }
    
    .table-responsive {
        font-size: 0.85rem;
    }
    
    .table thead th,
    .table tbody td {
        padding: 10px 8px;
    }
}
</style>

@endsection

@push('js')
<script>
$(document).ready(function() {
    let productIndex = 1;
    
    $('#add-product').click(function() {
        const newProduct = `
            <div class="row mb-2">
                <div class="col-md-6">
                    <select class="form-control" name="products[${productIndex}][id]" required>
                        <option value="">Select Product</option>
                        <!-- Add your products here -->
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="products[${productIndex}][quantity]" placeholder="Quantity" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger remove-product">Remove</button>
                </div>
            </div>
        `;
        $('#products-container').append(newProduct);
        productIndex++;
    });
    
    $(document).on('click', '.remove-product', function() {
        $(this).closest('.row').remove();
    });
});
</script>
@endpush 