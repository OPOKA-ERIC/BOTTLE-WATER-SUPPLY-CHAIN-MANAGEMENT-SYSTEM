@extends('layouts.app', ['activePage' => 'notifications', 'title' => 'Retailer Notifications'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Retailer Notifications</h1>
                        <p class="welcome-subtitle">Stay updated with your orders, deliveries, and important retailer alerts</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Stats -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="total-notifications">{{ $notifications->total() }}</h3>
                        <p class="stats-label">Total Retailer Notifications</p>
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
                        <i class="nc-icon nc-single-02"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number" id="unread-notifications">{{ $notifications->where('is_read', false)->count() }}</h3>
                        <p class="stats-label">Unread Retailer Notifications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Require attention</span>
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
                        <h3 class="stats-number" id="read-notifications">{{ $notifications->where('is_read', true)->count() }}</h3>
                        <p class="stats-label">Read Retailer Notifications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Already viewed</span>
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
                        <h3 class="stats-number" id="today-notifications">{{ $notifications->where('created_at', '>=', now()->startOfDay())->count() }}</h3>
                        <p class="stats-label">Today's Retailer Notifications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Recent activity</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Quick Actions</h1>
                        <p class="welcome-subtitle">Manage your notifications efficiently</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="quick-actions">
                    <button class="quick-action-btn" onclick="markAllAsRead()">
                        <div class="action-icon">
                            <i class="nc-icon nc-check-2"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Mark All as Read</span>
                            <span class="action-subtitle">Clear all unread notifications</span>
                        </div>
                    </button>
                    <button class="quick-action-btn" onclick="clearAllNotifications()">
                        <div class="action-icon">
                            <i class="nc-icon nc-simple-remove"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Clear All</span>
                            <span class="action-subtitle">Delete all notifications</span>
                        </div>
                    </button>
                    <button class="quick-action-btn" onclick="refreshNotifications()">
                        <div class="action-icon">
                            <i class="nc-icon nc-refresh-69"></i>
                        </div>
                        <div class="action-content">
                            <span class="action-title">Refresh</span>
                            <span class="action-subtitle">Update notification list</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-body">
                        <div class="filters-container">
                            <div class="filter-group">
                                <label for="status-filter">Status:</label>
                                <select id="status-filter" class="form-control" onchange="filterNotifications()">
                                    <option value="all">All Notifications</option>
                                    <option value="unread">Unread Only</option>
                                    <option value="read">Read Only</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="type-filter">Type:</label>
                                <select id="type-filter" class="form-control" onchange="filterNotifications()">
                                    <option value="all">All Types</option>
                                    <option value="info">Information</option>
                                    <option value="success">Success</option>
                                    <option value="warning">Warning</option>
                                    <option value="error">Error</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <button class="btn btn-primary" onclick="filterNotifications()">
                                    <i class="nc-icon nc-zoom-split-in"></i>
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="row">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-body">
                        <div id="notifications-container">
                            @if($notifications->count() > 0)
                                <div class="notifications-list">
                                    @foreach($notifications as $notification)
                                        <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }} {{ $notification->type }}" data-id="{{ $notification->id }}">
                                            <div class="notification-icon">
                                                <i class="{{ $notification->type === 'success' ? 'nc-icon nc-check-2' : ($notification->type === 'warning' ? 'nc-icon nc-alert-circle-i' : ($notification->type === 'error' ? 'nc-icon nc-simple-remove' : 'nc-icon nc-bell-55')) }}"></i>
                                            </div>
                                            <div class="notification-content">
                                                <h6 class="notification-title">{{ $notification->title }}</h6>
                                                <p class="notification-message">{{ $notification->message }}</p>
                                                <div class="notification-meta">
                                                    <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="notification-actions">
                                                @if(!$notification->is_read)
                                                    <button class="action-btn primary" onclick="markAsRead({{ $notification->id }})" title="Mark as Read">
                                                        <i class="nc-icon nc-check-2"></i>
                                                    </button>
                                                @endif
                                                <button class="action-btn danger" onclick="deleteNotification({{ $notification->id }})" title="Delete">
                                                    <i class="nc-icon nc-simple-remove"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Pagination -->
                                <div class="pagination-container">
                                    {{ $notifications->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="nc-icon nc-bell-55"></i>
                                    </div>
                                    <h3 class="empty-title">No Notifications</h3>
                                    <p class="empty-subtitle">You're all caught up! No notifications to display.</p>
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
    margin: 0 0 15px 0;
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

/* Filters */
.filters-container {
    display: flex;
    gap: 20px;
    align-items: end;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-group label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.filter-group select,
.filter-group button {
    padding: 10px 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.9rem;
}

/* Notifications List */
.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.notification-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.notification-item.unread {
    border-left: 4px solid #667eea;
    background: rgba(102, 126, 234, 0.05);
}

.notification-item.read {
    opacity: 0.7;
}

.notification-item.success {
    border-left: 4px solid #27ae60;
}

.notification-item.warning {
    border-left: 4px solid #f39c12;
}

.notification-item.error {
    border-left: 4px solid #e74c3c;
}

.notification-item.success .notification-icon {
    background: #27ae60;
}

.notification-item.warning .notification-icon {
    background: #f39c12;
}

.notification-item.error .notification-icon {
    background: #e74c3c;
}

.notification-item:not(.success):not(.warning):not(.error) .notification-icon {
    background: #667eea;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.notification-message {
    color: #7f8c8d;
    font-size: 0.85rem;
    margin-bottom: 8px;
    line-height: 1.4;
}

.notification-meta {
    display: flex;
    gap: 15px;
    font-size: 0.75rem;
    color: #95a5a6;
}

.notification-actions {
    display: flex;
    gap: 8px;
    flex-shrink: 0;
}

.action-btn {
    padding: 6px 10px;
    border: none;
    border-radius: 6px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 4px;
}

.action-btn.primary {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.action-btn.primary:hover {
    background: rgba(102, 126, 234, 0.2);
}

.action-btn.danger {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
}

.action-btn.danger:hover {
    background: rgba(231, 76, 60, 0.2);
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
    font-size: 2rem;
    color: white;
    margin: 0 auto 20px;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 10px;
}

.empty-subtitle {
    color: #7f8c8d;
    font-size: 1rem;
}

/* Pagination */
.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

/* Make pagination arrows smaller and match admin vendor applications page */
.pagination-sm .page-link, .pagination .page-link {
    font-size: 0.75rem;
    padding: 0.15rem 0.5rem;
    min-width: 22px;
    min-height: 22px;
    line-height: 1.1;
    border-radius: 4px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filters-container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .notification-item {
        flex-direction: column;
        gap: 10px;
    }
    
    .notification-actions {
        align-self: flex-end;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Helper to get the correct notifications route prefix
function getNotificationPrefix() {
    // Check if the current path starts with /retailer
    if (window.location.pathname.startsWith('/retailer')) {
        return '/retailer/notifications';
    }
    return '/notifications';
}

// Mark notification as read
function markAsRead(notificationId) {
    fetch(`${getNotificationPrefix()}/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.classList.remove('unread');
                notificationItem.classList.add('read');
                updateNotificationStats();
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// Mark all notifications as read
function markAllAsRead() {
    if (!confirm('Mark all notifications as read?')) return;
    
    fetch(`${getNotificationPrefix()}/mark-all-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            document.querySelectorAll('.notification-item.unread').forEach(item => {
                item.classList.remove('unread');
                item.classList.add('read');
            });
            updateNotificationStats();
        }
    })
    .catch(error => {
        console.error('Error marking all notifications as read:', error);
    });
}

// Delete notification
function deleteNotification(notificationId) {
    if (!confirm('Delete this notification?')) return;
    
    fetch(`${getNotificationPrefix()}/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove from UI
            const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.remove();
                updateNotificationStats();
            }
        }
    })
    .catch(error => {
        console.error('Error deleting notification:', error);
    });
}

// Clear all notifications
function clearAllNotifications() {
    if (!confirm('Delete all notifications? This action cannot be undone.')) return;
    
    fetch(`${getNotificationPrefix()}/clear-all`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear UI
            document.getElementById('notifications-container').innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                    <h3 class="empty-title">No Notifications</h3>
                    <p class="empty-subtitle">You're all caught up! No notifications to display.</p>
                </div>
            `;
            updateNotificationStats();
        }
    })
    .catch(error => {
        console.error('Error clearing all notifications:', error);
    });
}

// Filter notifications
function filterNotifications() {
    const status = document.getElementById('status-filter').value;
    const type = document.getElementById('type-filter').value;
    
    const url = new URL(window.location);
    url.searchParams.set('status', status);
    url.searchParams.set('type', type);
    
    window.location.href = url.toString();
}

// Refresh notifications
function refreshNotifications() {
    window.location.reload();
}

// Update notification stats
function updateNotificationStats() {
    const totalNotifications = document.querySelectorAll('.notification-item').length;
    const unreadNotifications = document.querySelectorAll('.notification-item.unread').length;
    const readNotifications = document.querySelectorAll('.notification-item.read').length;
    
    document.getElementById('total-notifications').textContent = totalNotifications;
    document.getElementById('unread-notifications').textContent = unreadNotifications;
    document.getElementById('read-notifications').textContent = readNotifications;
}

// Auto-refresh notifications every 30 seconds
setInterval(() => {
    // Only refresh if user is on the notifications page
    if (window.location.pathname.includes('/notifications')) {
        refreshNotifications();
    }
}, 30000);
</script>
@endsection 