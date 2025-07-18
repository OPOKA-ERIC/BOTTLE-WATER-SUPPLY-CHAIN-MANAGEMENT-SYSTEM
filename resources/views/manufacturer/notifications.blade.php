@extends('layouts.app', ['activePage' => 'notifications', 'title' => 'Manufacturer Notifications'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Manufacturer Notifications</h1>
                        <p class="welcome-subtitle">Stay updated with your production, inventory, and important system alerts</p>
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
                        <h3 class="stats-number" id="total-notifications">{{ $stats['total'] ?? $notifications->total() }}</h3>
                        <p class="stats-label">Total Notifications</p>
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
                        <h3 class="stats-number" id="unread-notifications">{{ $stats['unread'] ?? $notifications->where('is_read', false)->count() }}</h3>
                        <p class="stats-label">Unread Notifications</p>
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
                        <h3 class="stats-number" id="read-notifications">{{ $stats['read'] ?? $notifications->where('is_read', true)->count() }}</h3>
                        <p class="stats-label">Read Notifications</p>
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
                        <p class="stats-label">Today's Notifications</p>
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

/* --- Retailer-style info notification --- */
.notification-item.info {
    border-left: 4px solid #3498db;
    background: rgba(52, 152, 219, 0.05);
}
.notification-item.info .notification-icon {
    background: #3498db;
}
/* --- End retailer-style info notification --- */

.card-header-blue {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.card-header-blue .card-title,
.card-header-blue .card-subtitle,
.card-header-blue .header-icon i {
    color: white !important;
}
</style>
<script>
function markAsRead(id) {
    var btn = event.target.closest('button');
    btn.disabled = true;
    fetch(`/manufacturer/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(() => location.reload())
    .catch(() => { alert('Failed to mark as read.'); btn.disabled = false; });
}
function deleteNotification(id) {
    var btn = event.target.closest('button');
    btn.disabled = true;
    fetch(`/manufacturer/notifications/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(() => location.reload())
    .catch(() => { alert('Failed to delete notification.'); btn.disabled = false; });
}
function markAllAsRead() {
    var btn = event.target.closest('button');
    btn.disabled = true;
    fetch('/manufacturer/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(() => location.reload())
    .catch(() => { alert('Failed to mark all as read.'); btn.disabled = false; });
}
function clearAllNotifications() {
    var btn = event.target.closest('button');
    btn.disabled = true;
    fetch('/manufacturer/notifications', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(() => location.reload())
    .catch(() => { alert('Failed to clear all notifications.'); btn.disabled = false; });
}
function refreshNotifications() {
    location.reload();
}
function filterNotifications() {
    // TODO: Filter notifications in the DOM or via AJAX
}
</script>
@endsection 