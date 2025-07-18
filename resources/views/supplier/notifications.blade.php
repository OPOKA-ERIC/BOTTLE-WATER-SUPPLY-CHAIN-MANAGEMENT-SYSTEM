@extends('layouts.app', ['activePage' => 'notifications', 'title' => 'Supplier Notifications'])

@section('content')
<!-- Real-time Indicator -->
{{-- Removed real-time-indicator (Live Updates) --}}
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
                        <h3 class="stats-number" id="total-notifications">{{ $stats['total'] ?? 0 }}</h3>
                        <p class="stats-label">Total Notifications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span id="last-updated">Updated just now</span>
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
                        <h3 class="stats-number" id="order-notifications">{{ $stats['orders'] ?? 0 }}</h3>
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
                        <h3 class="stats-number" id="material-notifications">{{ $stats['materials'] ?? 0 }}</h3>
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
                        <h3 class="stats-number" id="system-notifications">{{ $stats['system'] ?? 0 }}</h3>
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
                            <button class="filter-btn" data-filter="order">
                                <i class="nc-icon nc-cart-simple"></i>
                                <span>Orders</span>
                            </button>
                            <button class="filter-btn" data-filter="material">
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
                        
                        <div class="bulk-actions">
                            <button class="action-btn secondary" id="mark-all-read">
                                <i class="nc-icon nc-check-2"></i>
                                <span>Mark All Read</span>
                            </button>
                            <button class="action-btn danger" id="clear-all">
                                <i class="nc-icon nc-simple-remove"></i>
                                <span>Clear All</span>
                            </button>
                            <button class="action-btn primary" id="refresh-notifications">
                                <i class="nc-icon nc-refresh-69"></i>
                                <span>Refresh</span>
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
                            @if(isset($notifications) && $notifications->count() > 0)
                                @foreach($notifications as $notification)
                                    <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}" data-type="{{ $notification->type }}" data-id="{{ $notification->id }}">
                                        <div class="notification-icon {{ $notification->type }}">
                                            <i class="nc-icon {{ $notification->type === 'order' ? 'nc-cart-simple' : ($notification->type === 'material' ? 'nc-box-2' : 'nc-alert-circle-i') }}"></i>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-header">
                                                <h6 class="notification-title">{{ $notification->title }}</h6>
                                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="notification-message">{{ $notification->message }}</p>
                                            <div class="notification-actions">
                                                @if($notification->type === 'order' && isset($notification->data['order_id']))
                                                    <a href="{{ route('supplier.orders.show', $notification->data['order_id']) }}" class="action-btn primary">
                                                        <i class="nc-icon nc-zoom-split-in"></i>
                                                        <span>View Order</span>
                                                    </a>
                                                @endif
                                                @if($notification->type === 'material')
                                                    <a href="{{ route('supplier.materials') }}" class="action-btn primary">
                                                        <i class="nc-icon nc-zoom-split-in"></i>
                                                        <span>View Materials</span>
                                                    </a>
                                                @endif
                                                @if(!$notification->is_read)
                                                    <button class="action-btn secondary mark-read" data-id="{{ $notification->id }}">
                                                        <i class="nc-icon nc-check-2"></i>
                                                        <span>Mark Read</span>
                                                    </button>
                                                @endif
                                                <button class="action-btn danger delete-notification" data-id="{{ $notification->id }}">
                                                    <i class="nc-icon nc-simple-remove"></i>
                                                    <span>Delete</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="notification-status">
                                            <span class="status-dot {{ $notification->is_read ? 'read' : 'unread' }}"></span>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <!-- Pagination -->
                                <div class="pagination-section">
                                    {{ $notifications->links() }}
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="nc-icon nc-bell-55"></i>
                                    </div>
                                    <h5 class="empty-title">No Notifications</h5>
                                    <p class="empty-subtitle">You're all caught up! No new notifications at the moment.</p>
                                </div>
                            @endif
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

.action-btn.danger {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border: 1px solid rgba(220, 53, 69, 0.2);
}

.action-btn.danger:hover {
    background: rgba(220, 53, 69, 0.2);
    transform: translateY(-2px);
}

/* Bulk Actions */
.bulk-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    flex-wrap: wrap;
}

.bulk-actions .action-btn {
    flex: 1;
    min-width: 120px;
    justify-content: center;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #495057;
}

.empty-subtitle {
    font-size: 1rem;
    opacity: 0.7;
    margin: 0;
}

/* Pagination */
.pagination-section {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

/* Remove the .real-time-indicator CSS and related keyframes */
/*
.real-time-indicator {
    position: fixed;
    top: 20px;
    right: 20px;
    background: rgba(40, 167, 69, 0.9);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 8px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}
*/

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
    let refreshInterval;
    const REFRESH_INTERVAL = 30000; // 30 seconds

    // Initialize real-time updates
    initRealTimeUpdates();

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
    document.addEventListener('click', function(e) {
        if (e.target.closest('.mark-read')) {
            const button = e.target.closest('.mark-read');
            const notificationId = button.getAttribute('data-id');
            markAsRead(notificationId);
        }
    });

    // Delete notification functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-notification')) {
            const button = e.target.closest('.delete-notification');
            const notificationId = button.getAttribute('data-id');
            deleteNotification(notificationId);
        }
    });

    // Bulk actions
    document.getElementById('mark-all-read').addEventListener('click', markAllAsRead);
    document.getElementById('clear-all').addEventListener('click', clearAllNotifications);
    document.getElementById('refresh-notifications').addEventListener('click', refreshNotifications);

    // Real-time update functions
    function initRealTimeUpdates() {
        // Start periodic refresh
        refreshInterval = setInterval(refreshNotifications, REFRESH_INTERVAL);
        
        // Update last updated time
        updateLastUpdatedTime();
    }

    function refreshNotifications() {
        fetch('{{ route("supplier.notifications.api") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateNotificationsList(data.notifications);
                    updateStats();
                }
            })
            .catch(error => {
                console.error('Error refreshing notifications:', error);
            });
    }

    function updateNotificationsList(notifications) {
        const container = document.getElementById('notifications-container');
        
        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                    <h5 class="empty-title">No Notifications</h5>
                    <p class="empty-subtitle">You're all caught up! No new notifications at the moment.</p>
                </div>
            `;
            return;
        }

        let html = '';
        notifications.forEach(notification => {
            const isUnread = !notification.is_read;
            const typeIcon = notification.type === 'order' ? 'nc-cart-simple' : 
                           (notification.type === 'material' ? 'nc-box-2' : 'nc-alert-circle-i');
            
            html += `
                <div class="notification-item ${isUnread ? 'unread' : ''}" data-type="${notification.type}" data-id="${notification.id}">
                    <div class="notification-icon ${notification.type}">
                        <i class="nc-icon ${typeIcon}"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-header">
                            <h6 class="notification-title">${notification.title}</h6>
                            <span class="notification-time">${notification.created_at}</span>
                        </div>
                        <p class="notification-message">${notification.message}</p>
                        <div class="notification-actions">
                            ${notification.type === 'order' && notification.data && notification.data.order_id ? 
                                `<a href="/supplier/orders/${notification.data.order_id}" class="action-btn primary">
                                    <i class="nc-icon nc-zoom-split-in"></i>
                                    <span>View Order</span>
                                </a>` : ''
                            }
                            ${notification.type === 'material' ? 
                                `<a href="{{ route('supplier.materials') }}" class="action-btn primary">
                                    <i class="nc-icon nc-zoom-split-in"></i>
                                    <span>View Materials</span>
                                </a>` : ''
                            }
                            ${isUnread ? 
                                `<button class="action-btn secondary mark-read" data-id="${notification.id}">
                                    <i class="nc-icon nc-check-2"></i>
                                    <span>Mark Read</span>
                                </button>` : ''
                            }
                            <button class="action-btn danger delete-notification" data-id="${notification.id}">
                                <i class="nc-icon nc-simple-remove"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    <div class="notification-status">
                        <span class="status-dot ${isUnread ? 'unread' : 'read'}"></span>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    function updateStats() {
        fetch('{{ route("supplier.notifications.stats") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const stats = data.stats;
                    document.getElementById('total-notifications').textContent = stats.total;
                    document.getElementById('order-notifications').textContent = stats.orders;
                    document.getElementById('material-notifications').textContent = stats.materials;
                    document.getElementById('system-notifications').textContent = stats.system;
                    updateLastUpdatedTime();
                }
            })
            .catch(error => {
                console.error('Error updating stats:', error);
            });
    }

    function markAsRead(notificationId) {
        fetch(`{{ route('supplier.notifications.read', '') }}/${notificationId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.classList.remove('unread');
                    const statusDot = notificationItem.querySelector('.status-dot');
                    statusDot.classList.remove('unread');
                    statusDot.classList.add('read');
                    
                    // Remove mark read button
                    const markReadBtn = notificationItem.querySelector('.mark-read');
                    if (markReadBtn) {
                        markReadBtn.remove();
                    }
                }
                updateStats();
            }
        })
        .catch(error => {
            console.error('Error marking as read:', error);
        });
    }

    function markAllAsRead() {
        fetch('{{ route("supplier.notifications.mark-all-read") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    const statusDot = item.querySelector('.status-dot');
                    statusDot.classList.remove('unread');
                    statusDot.classList.add('read');
                    
                    // Remove mark read button
                    const markReadBtn = item.querySelector('.mark-read');
                    if (markReadBtn) {
                        markReadBtn.remove();
                    }
                });
                updateStats();
            }
        })
        .catch(error => {
            console.error('Error marking all as read:', error);
        });
    }

    function deleteNotification(notificationId) {
        if (confirm('Are you sure you want to delete this notification?')) {
            fetch(`{{ route('supplier.notifications.delete', '') }}/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
                    if (notificationItem) {
                        notificationItem.remove();
                    }
                    updateStats();
                }
            })
            .catch(error => {
                console.error('Error deleting notification:', error);
            });
        }
    }

    function clearAllNotifications() {
        if (confirm('Are you sure you want to clear all notifications? This action cannot be undone.')) {
            fetch('{{ route("supplier.notifications.clear-all") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notifications-container').innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="nc-icon nc-bell-55"></i>
                            </div>
                            <h5 class="empty-title">No Notifications</h5>
                            <p class="empty-subtitle">You're all caught up! No new notifications at the moment.</p>
                        </div>
                    `;
                    updateStats();
                }
            })
            .catch(error => {
                console.error('Error clearing notifications:', error);
            });
        }
    }

    function updateLastUpdatedTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        document.getElementById('last-updated').textContent = `Updated at ${timeString}`;
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    });
});
</script>

<!-- Real-time notifications with Laravel Echo -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.0/echo.iife.js"></script>
<script>
    // Get the authenticated supplier's user ID from backend
    const supplierUserId = {{ auth()->id() }};
    // Setup Echo instance
    window.Echo = new window.Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true,
        encrypted: true,
    });
    // Listen for real-time notifications
    window.Echo.private('supplier.notifications.' + supplierUserId)
        .listen('SupplierNotificationCreated', (e) => {
            // Prepend the new notification to the list
            fetchNotifications();
            updateStats();
            // Optionally, show a toast or highlight
            showRealTimeIndicator();
        });
    function showRealTimeIndicator() {
        const indicator = document.getElementById('real-time-indicator');
        if (indicator) {
            indicator.classList.add('active');
            setTimeout(() => indicator.classList.remove('active'), 2000);
        }
    }
</script>
@endsection 