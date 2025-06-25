@extends('layouts.app', ['activePage' => 'notifications', 'title' => 'Vendor Notifications'])

@section('content')
    <div class="content">
        <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Vendor Notifications Center</h1>
                        <p class="welcome-subtitle">Stay updated with your vendor applications, orders, and important system alerts</p>
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
                        <h3 class="stats-number" id="total-notifications">12</h3>
                        <p class="stats-label">Total Vendor Notifications</p>
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
                        <h3 class="stats-number" id="order-notifications">5</h3>
                        <p class="stats-label">Vendor Order Updates</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Latest vendor orders</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-delivery-fast"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="delivery-notifications">3</h3>
                        <p class="stats-label">Vendor Delivery Alerts</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Shipping updates</span>
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
                        <h3 class="stats-number" id="system-notifications">4</h3>
                        <p class="stats-label">Vendor System Alerts</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Important vendor updates</span>
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
                            <h4 class="card-title">Filter Vendor Notifications</h4>
                            <p class="card-subtitle">View notifications by type and status for your vendor account</p>
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
                                <span>Vendor Orders</span>
                            </button>
                            <button class="filter-btn" data-filter="delivery">
                                <i class="nc-icon nc-delivery-fast"></i>
                                <span>Vendor Delivery</span>
                            </button>
                            <button class="filter-btn" data-filter="system">
                                <i class="nc-icon nc-alert-circle-i"></i>
                                <span>Vendor System</span>
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
                            <h4 class="card-title">Recent Vendor Notifications</h4>
                            <p class="card-subtitle">Your latest vendor notifications and updates</p>
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
                                        <h6 class="notification-title">Order #1234 Status Updated</h6>
                                        <span class="notification-time">2 minutes ago</span>
                                    </div>
                                    <p class="notification-message">Your order has been processed and is now being prepared for shipment.</p>
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

                            <!-- Delivery Notification -->
                            <div class="notification-item unread" data-type="delivery">
                                <div class="notification-icon delivery">
                                    <i class="nc-icon nc-delivery-fast"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Delivery Scheduled</h6>
                                        <span class="notification-time">15 minutes ago</span>
                                    </div>
                                    <p class="notification-message">Your delivery for Order #1234 is scheduled for tomorrow between 9 AM - 12 PM.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn primary">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>Track Delivery</span>
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
                                        <span class="notification-time">1 hour ago</span>
                                    </div>
                                    <p class="notification-message">Scheduled maintenance will occur tonight from 2 AM to 4 AM. Some services may be temporarily unavailable.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn secondary">
                                            <i class="nc-icon nc-info"></i>
                                            <span>Learn More</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>

                            <!-- Order Notification -->
                            <div class="notification-item" data-type="orders">
                                <div class="notification-icon order">
                                    <i class="nc-icon nc-cart-simple"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Order #1235 Confirmed</h6>
                                        <span class="notification-time">2 hours ago</span>
                                    </div>
                                    <p class="notification-message">Your order has been confirmed and payment received. Processing will begin shortly.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn primary">
                                            <i class="nc-icon nc-zoom-split-in"></i>
                                            <span>View Order</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>

                            <!-- Delivery Notification -->
                            <div class="notification-item" data-type="delivery">
                                <div class="notification-icon delivery">
                                    <i class="nc-icon nc-delivery-fast"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Delivery Completed</h6>
                                        <span class="notification-time">1 day ago</span>
                                    </div>
                                    <p class="notification-message">Your delivery for Order #1230 has been completed successfully. Thank you for your business!</p>
                                    <div class="notification-actions">
                                        <button class="action-btn secondary">
                                            <i class="nc-icon nc-chart-bar-32"></i>
                                            <span>Rate Delivery</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>

                            <!-- System Notification -->
                            <div class="notification-item" data-type="system">
                                <div class="notification-icon system">
                                    <i class="nc-icon nc-alert-circle-i"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">New Features Available</h6>
                                        <span class="notification-time">2 days ago</span>
                                    </div>
                                    <p class="notification-message">We've added new features to improve your experience. Check out the latest updates in your dashboard.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn secondary">
                                            <i class="nc-icon nc-info"></i>
                                            <span>View Updates</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <span class="status-dot read"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Load More Button -->
                        <div class="load-more-section">
                            <button class="load-more-btn">
                                <i class="nc-icon nc-refresh-69"></i>
                                <span>Load More Notifications</span>
                            </button>
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

/* Filter Buttons */
.filter-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid rgba(25, 118, 210, 0.1);
    border-radius: 12px;
    color: #666;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: rgba(25, 118, 210, 0.1);
    border-color: #1976d2;
    color: #1976d2;
    transform: translateY(-2px);
}

.filter-btn.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.filter-btn i {
    font-size: 16px;
}

/* Notifications List */
.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    position: relative;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.95);
}

.notification-item.unread {
    background: rgba(25, 118, 210, 0.05);
    border-color: rgba(25, 118, 210, 0.2);
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.notification-icon.order {
    background: linear-gradient(135deg, #4caf50, #66bb6a);
}

.notification-icon.delivery {
    background: linear-gradient(135deg, #ff9800, #ffb74d);
}

.notification-icon.system {
    background: linear-gradient(135deg, #f44336, #ef5350);
}

.notification-icon i {
    font-size: 24px;
    color: white;
}

.notification-content {
    flex: 1;
}

.notification-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}

.notification-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.notification-time {
    font-size: 0.85rem;
    color: #666;
    font-weight: 500;
}

.notification-message {
    font-size: 0.95rem;
    color: #666;
    margin: 0 0 15px 0;
    line-height: 1.5;
}

.notification-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

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

.action-btn.secondary {
    background: rgba(25, 118, 210, 0.1);
    color: #1976d2;
    border: 1px solid rgba(25, 118, 210, 0.2);
}

.action-btn.secondary:hover {
    background: rgba(25, 118, 210, 0.2);
    transform: translateY(-2px);
}

.action-btn i {
    font-size: 14px;
}

.notification-status {
    position: absolute;
    top: 20px;
    right: 20px;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: block;
}

.status-dot.unread {
    background: #1976d2;
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.2);
}

.status-dot.read {
    background: #ccc;
}

/* Load More Section */
.load-more-section {
    text-align: center;
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.load-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.load-more-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.load-more-btn i {
    font-size: 18px;
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
    
    .filter-buttons {
        justify-content: center;
    }
    
    .notification-item {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .notification-header {
        flex-direction: column;
        gap: 5px;
    }
    
    .notification-actions {
        justify-content: center;
    }
    
    .notification-status {
        position: static;
        margin-top: 10px;
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
                if (filter === 'all' || item.getAttribute('data-type') === filter || 
                    (filter === 'unread' && item.classList.contains('unread'))) {
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

    // Update notification counters
    function updateNotificationCounters() {
        const totalNotifications = document.querySelectorAll('.notification-item').length;
        const unreadNotifications = document.querySelectorAll('.notification-item.unread').length;
        const orderNotifications = document.querySelectorAll('.notification-item[data-type="orders"]').length;
        const deliveryNotifications = document.querySelectorAll('.notification-item[data-type="delivery"]').length;
        const systemNotifications = document.querySelectorAll('.notification-item[data-type="system"]').length;

        document.getElementById('total-notifications').textContent = totalNotifications;
        document.getElementById('order-notifications').textContent = orderNotifications;
        document.getElementById('delivery-notifications').textContent = deliveryNotifications;
        document.getElementById('system-notifications').textContent = systemNotifications;
    }

    // Load more functionality
    const loadMoreBtn = document.querySelector('.load-more-btn');
    loadMoreBtn.addEventListener('click', function() {
        // Simulate loading more notifications
        this.innerHTML = '<i class="nc-icon nc-refresh-69"></i><span>Loading...</span>';
        
        setTimeout(() => {
            this.innerHTML = '<i class="nc-icon nc-refresh-69"></i><span>Load More Notifications</span>';
            // Here you would typically load more notifications from the server
        }, 2000);
    });
});
</script>
@endsection