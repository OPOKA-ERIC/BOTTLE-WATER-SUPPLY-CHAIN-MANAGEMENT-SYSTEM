@extends('layouts.app', ['activePage' => 'notifications', 'title' => 'Supplier Notifications'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Notifications Center</h1>
                        <p class="welcome-subtitle">Stay updated with your orders, materials, and important system alerts</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Statistics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="total-notifications">8</h3>
                        <p class="stats-label">Total Notifications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Updated just now</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-cart-simple"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="order-notifications">3</h3>
                        <p class="stats-label">Order Updates</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Latest orders</span>
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
                        <h3 class="stats-number" id="material-notifications">2</h3>
                        <p class="stats-label">Material Alerts</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Inventory updates</span>
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
                        <h3 class="stats-number" id="system-notifications">3</h3>
                        <p class="stats-label">System Alerts</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Important updates</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Filter Notifications</h4>
                            <p class="card-subtitle">View notifications by type and status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-filter="all">
                                <i class="nc-icon nc-bell-55"></i>
                                <span>All</span>
                            </button>
                            <button class="filter-btn" data-filter="orders">
                                <i class="nc-icon nc-cart-simple"></i>
                                <span>Orders</span>
                            </button>
                            <button class="filter-btn" data-filter="materials">
                                <i class="nc-icon nc-box-2"></i>
                                <span>Materials</span>
                            </button>
                            <button class="filter-btn" data-filter="system">
                                <i class="nc-icon nc-alert-circle-i"></i>
                                <span>System</span>
                            </button>
                            <button class="filter-btn" data-filter="unread">
                                <i class="nc-icon nc-badge"></i>
                                <span>Unread</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="row">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Notifications</h4>
                            <p class="card-subtitle">Your latest notifications and updates</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-bell-55"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="notifications-list" id="notifications-container">
                            <!-- Order Notification -->
                            <div class="notification-item unread" data-type="orders">
                                <div class="notification-icon order">
                                    <i class="nc-icon nc-cart-simple"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">New Purchase Order Received</h6>
                                        <span class="notification-time">5 minutes ago</span>
                                    </div>
                                    <p class="notification-message">Manufacturer ABC has placed a new order for 500 bottles. Please review and confirm.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn primary">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>View Order</span>
                                        </button>
                                        <button class="action-btn secondary mark-read">
                                            <i class="nc-icon nc-check-2"></i>
                                            <span>Mark Read</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot unread"></span>
                                </div>
                            </div>

                            <!-- Material Notification -->
                            <div class="notification-item unread" data-type="materials">
                                <div class="notification-icon material">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Low Inventory Alert</h6>
                                        <span class="notification-time">1 hour ago</span>
                                    </div>
                                    <p class="notification-message">Your plastic bottle inventory is running low. Consider restocking soon.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn primary">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>View Inventory</span>
                                        </button>
                                        <button class="action-btn secondary mark-read">
                                            <i class="nc-icon nc-check-2"></i>
                                            <span>Mark Read</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot unread"></span>
                                </div>
                            </div>

                            <!-- System Notification -->
                            <div class="notification-item" data-type="system">
                                <div class="notification-icon system">
                                    <i class="nc-icon nc-alert-circle-i"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">System Maintenance</h6>
                                        <span class="notification-time">2 hours ago</span>
                                    </div>
                                    <p class="notification-message">Scheduled maintenance will occur tonight from 2 AM to 4 AM. Some features may be temporarily unavailable.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn secondary mark-read">
                                            <i class="nc-icon nc-check-2"></i>
                                            <span>Mark Read</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>

                            <!-- Order Status Update -->
                            <div class="notification-item" data-type="orders">
                                <div class="notification-icon order">
                                    <i class="nc-icon nc-cart-simple"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Order Status Updated</h6>
                                        <span class="notification-time">3 hours ago</span>
                                    </div>
                                    <p class="notification-message">Order #PO-2024-001 has been marked as 'In Production' by the manufacturer.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn primary">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>View Order</span>
                                        </button>
                                        <button class="action-btn secondary mark-read">
                                            <i class="nc-icon nc-check-2"></i>
                                            <span>Mark Read</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>

                            <!-- Material Delivery -->
                            <div class="notification-item" data-type="materials">
                                <div class="notification-icon material">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Material Delivery Confirmed</h6>
                                        <span class="notification-time">1 day ago</span>
                                    </div>
                                    <p class="notification-message">Your shipment of 1000 plastic bottles has been delivered and added to inventory.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn primary">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>View Inventory</span>
                                        </button>
                                        <button class="action-btn secondary mark-read">
                                            <i class="nc-icon nc-check-2"></i>
                                            <span>Mark Read</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>

                            <!-- Payment Notification -->
                            <div class="notification-item" data-type="orders">
                                <div class="notification-icon order">
                                    <i class="nc-icon nc-money-coins"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Payment Received</h6>
                                        <span class="notification-time">2 days ago</span>
                                    </div>
                                    <p class="notification-message">Payment of $2,500 has been received for Order #PO-2024-002.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn primary">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>View Details</span>
                                        </button>
                                        <button class="action-btn secondary mark-read">
                                            <i class="nc-icon nc-check-2"></i>
                                            <span>Mark Read</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>
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

/* Filter Buttons */
.filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.filter-btn {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #6c757d;
    transition: all 0.3s ease;
    cursor: pointer;
}

.filter-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
}

.filter-btn i {
    font-size: 1rem;
}

/* Notifications List */
.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.notification-item {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    padding: 25px;
    display: flex;
    align-items: flex-start;
    gap: 20px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
}

.notification-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.notification-item.unread {
    background: rgba(102, 126, 234, 0.05);
    border-left: 4px solid #667eea;
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.notification-icon.order {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.notification-icon.material {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.notification-icon.system {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.notification-content {
    flex: 1;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.notification-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.notification-time {
    font-size: 0.85rem;
    color: #95a5a6;
    font-weight: 400;
}

.notification-message {
    color: #7f8c8d;
    margin-bottom: 15px;
    line-height: 1.5;
}

.notification-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

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

.notification-status {
    position: absolute;
    top: 25px;
    right: 25px;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: block;
}

.status-dot.unread {
    background: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.status-dot.read {
    background: #95a5a6;
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
    
    .filter-buttons {
        justify-content: center;
    }
    
    .notification-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .notification-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .notification-actions {
        justify-content: flex-start;
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
    
    .notification-item {
        padding: 20px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const notificationItems = document.querySelectorAll('.notification-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter notifications
            notificationItems.forEach(item => {
                const type = item.getAttribute('data-type');
                const isUnread = item.classList.contains('unread');
                
                if (filter === 'all' || 
                    (filter === 'unread' && isUnread) || 
                    (filter !== 'unread' && type === filter)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Mark as read functionality
    const markReadButtons = document.querySelectorAll('.mark-read');
    markReadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const notificationItem = this.closest('.notification-item');
            const statusDot = notificationItem.querySelector('.status-dot');
            
            notificationItem.classList.remove('unread');
            statusDot.classList.remove('unread');
            statusDot.classList.add('read');
            
            // Update counters
            updateNotificationCounters();
        });
    });

    function updateNotificationCounters() {
        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
        const totalCount = document.querySelectorAll('.notification-item').length;
        
        // Update total notifications
        document.getElementById('total-notifications').textContent = totalCount;
        
        // You can add more counter updates here based on your needs
    }
});
</script>
@endsection 