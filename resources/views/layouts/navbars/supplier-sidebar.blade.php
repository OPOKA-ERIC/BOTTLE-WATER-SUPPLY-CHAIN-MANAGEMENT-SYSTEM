<div class="supplier-sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <div class="sidebar-overlay"></div>
    <div class="sidebar-wrapper">
        <!-- Logo Section -->
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="nc-icon nc-box-2"></i>
                </div>
                <div class="logo-text">
                    <h3 class="logo-title">BWSCMS</h3>
                    <p class="logo-subtitle">Supplier Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="sidebar-nav">
            <ul class="nav-menu">
                <!-- Dashboard -->
                <li class="nav-item @if($activePage == 'dashboard') active @endif">
                    <a class="nav-link" href="{{route('supplier.dashboard')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-chart-pie-35"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Dashboard") }}</span>
                            <span class="nav-subtitle">Overview</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Materials -->
                <li class="nav-item @if($activePage == 'materials') active @endif">
                    <a class="nav-link" href="{{route('supplier.materials')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Materials") }}</span>
                            <span class="nav-subtitle">Manage inventory</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item @if($activePage == 'orders') active @endif">
                    <a class="nav-link" href="{{route('supplier.orders.index')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Orders") }}</span>
                            <span class="nav-subtitle">Purchase orders</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Chat -->
                <li class="nav-item @if($activePage == 'chat') active @endif">
                    <a class="nav-link" href="{{route('supplier.chats.index')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-chat-33"></i>
                            <span class="notification-badge" id="chatNotificationBadge" style="display: none;">0</span>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Chat") }}</span>
                            <span class="nav-subtitle">Communications</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- User Profile -->
                <li class="nav-item @if($activePage == 'user') active @endif">
                    <a class="nav-link" href="{{route('profile.edit')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-single-02"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("User Profile") }}</span>
                            <span class="nav-subtitle">Your profile</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item @if($activePage == 'notifications') active @endif">
                    <a class="nav-link" href="{{ route('supplier.notifications') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-bell-55"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Notifications") }}</span>
                            <span class="nav-subtitle">System alerts</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <!-- Logout Button -->
            <div class="logout-section">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <div class="logout-icon">
                            <i class="nc-icon nc-button-power"></i>
                        </div>
                        <div class="logout-content">
                            <span class="logout-title">{{ __("Logout") }}</span>
                            <span class="logout-subtitle">Sign out</span>
                        </div>
                    </button>
                </form>
            </div>

            <!-- Supplier Info -->
            <div class="supplier-info">
                <div class="supplier-avatar">
                    <i class="nc-icon nc-single-02"></i>
                </div>
                <div class="supplier-details">
                    <span class="supplier-name">Supplier</span>
                    <span class="supplier-role">Material Provider</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.supplier-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 280px;
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    z-index: 1000;
    overflow-y: auto;
    transition: all 0.3s ease;
}

.sidebar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1);
    pointer-events: none;
}

.sidebar-wrapper {
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    padding: 0;
}

/* Header Section */
.sidebar-header {
    padding: 30px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.logo-icon i {
    font-size: 24px;
    color: white;
}

.logo-text {
    flex: 1;
}

.logo-title {
    color: white;
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.logo-subtitle {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.85rem;
    margin: 0;
    font-weight: 400;
}

/* Navigation Menu */
.sidebar-nav {
    flex: 1;
    padding: 20px 0;
}

.nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    margin: 5px 15px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.nav-item.active {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
}

.nav-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 20px;
    color: white;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
}

.nav-link:hover {
    color: white;
    text-decoration: none;
}

.nav-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.nav-item.active .nav-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.nav-icon i {
    font-size: 18px;
    color: white;
}

.nav-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.nav-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: white;
    margin: 0;
    line-height: 1.2;
}

.nav-subtitle {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 2px 0 0 0;
    font-weight: 400;
}

.nav-indicator {
    width: 4px;
    height: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 2px;
    opacity: 0;
    transition: all 0.3s ease;
}

.nav-item.active .nav-indicator {
    opacity: 1;
}

/* Sidebar Footer */
.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
}

/* Logout Section */
.logout-section {
    margin-bottom: 20px;
}

.logout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.2);
    border-radius: 12px;
    color: #dc3545;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background: rgba(220, 53, 69, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.logout-icon {
    width: 32px;
    height: 32px;
    background: rgba(220, 53, 69, 0.2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.logout-icon i {
    font-size: 16px;
    color: #dc3545;
}

.logout-content {
    flex: 1;
    text-align: left;
}

.logout-title {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #dc3545;
    margin: 0;
    line-height: 1.2;
}

.logout-subtitle {
    display: block;
    font-size: 0.75rem;
    color: rgba(220, 53, 69, 0.7);
    margin: 2px 0 0 0;
    font-weight: 400;
}

/* Supplier Info */
.supplier-info {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.supplier-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.supplier-avatar i {
    font-size: 18px;
    color: white;
}

.supplier-details {
    flex: 1;
}

.supplier-name {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: white;
    margin: 0;
    line-height: 1.2;
}

.supplier-role {
    display: block;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 2px 0 0 0;
    font-weight: 400;
}

/* Responsive Design */
@media (max-width: 768px) {
    .supplier-sidebar {
        width: 100%;
        transform: translateX(-100%);
    }

    .supplier-sidebar.show {
        transform: translateX(0);
    }

    .sidebar-header {
        padding: 20px 15px;
    }

    .nav-item {
        margin: 3px 10px;
    }

    .nav-link {
        padding: 12px 15px;
    }

    .sidebar-footer {
        padding: 15px;
    }
}

/* Animation for active state */
.nav-item.active .nav-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    50% {
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.6);
    }
    100% {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
}

/* Notification Badge */
.nav-icon {
    position: relative;
}

.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 600;
    border: 2px solid rgba(25, 118, 210, 0.95);
    animation: notification-pulse 2s infinite;
}

@keyframes notification-pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}
    50% {
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.6);
    }
    100% {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
}
</style>

<script>
// Update chat notification badge
function updateChatNotificationBadge() {
    fetch('{{ route("supplier.chats.unread-count") }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('chatNotificationBadge');
            if (data.unread_count > 0) {
                badge.textContent = data.unread_count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error fetching unread count:', error);
        });
}

// Update badge on page load
document.addEventListener('DOMContentLoaded', function() {
    updateChatNotificationBadge();

    // Update badge every 30 seconds
    setInterval(updateChatNotificationBadge, 30000);
});
</script>
