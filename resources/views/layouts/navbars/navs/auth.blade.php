<nav class="admin-navbar">
    <div class="navbar-container">
        

       

        <!-- Right Section -->
        <div class="navbar-right">
            <!-- Search -->
            <div class="nav-item search-container">
                <div class="search-box">
                    <i class="nc-icon nc-zoom-split search-icon"></i>
                    <input type="text" placeholder="Search..." class="search-input">
                </div>
            </div>

            <!-- Notifications - For All Users -->
            <div class="nav-item notification-container">
                <button class="notification-btn" data-toggle="dropdown" id="userNotificationBtn">
                    <i class="nc-icon nc-bell-55"></i>
                    @if(auth()->user()->unreadNotifications->count())
                        <span class="notification-badge" id="notificationCount">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </button>
                <div class="dropdown-menu notification-dropdown">
                    <div class="dropdown-header">
                        <h6>Notifications</h6>
                        <span class="notification-count" id="notificationCountText">{{ auth()->user()->unreadNotifications->count() }} new</span>
                    </div>
                    <div class="notification-list" id="userNotificationList">
                        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                            @php
                                $taskId = $notification->data['task_id'] ?? null;
                                $role = auth()->user()->role;
                                if ($role === 'administrator' && $taskId) {
                                    $link = route('admin.tasks.show', $taskId);
                                } elseif ($role === 'manufacturer' && $taskId) {
                                    $link = route('manufacturer.tasks.assigned');
                                } else {
                                    $link = route($role . '.dashboard');
                                }
                            @endphp
                            <a href="{{ $link }}" class="dropdown-item">
                                {{ $notification->data['message'] ?? $notification->data['title'] ?? 'New Notification' }}
                                <br>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </a>
                        @empty
                            <span class="dropdown-item">No new notifications</span>
                        @endforelse
                    </div>
                    <div class="dropdown-footer">
                        <a href="{{ route((auth()->user()->role === 'administrator' ? 'admin' : auth()->user()->role) . '.notifications') }}" class="view-all-link">View All Notifications</a>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="nav-item user-container">
                <button class="user-btn" data-toggle="dropdown">
                    <div class="user-avatar">
                        <i class="nc-icon nc-single-02"></i>
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                    <i class="nc-icon nc-minimal-down dropdown-arrow"></i>
        </button>
                <div class="dropdown-menu user-dropdown">
                    <div class="dropdown-header">
                        <div class="user-profile">
                            <div class="profile-avatar">
                                <i class="nc-icon nc-single-02"></i>
                            </div>
                            <div class="profile-info">
                                <div class="profile-name">{{ auth()->user()->name }}</div>
                                <div class="profile-email">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="nc-icon nc-single-02"></i>
                            <span>My Profile</span>
                        </a>
                        @if(auth()->user()->role === 'administrator')
                        <a href="{{ route('admin.analytics') }}" class="dropdown-item" onclick="event.stopPropagation(); window.location.href='{{ route('admin.analytics') }}'; return false;" target="_self">
                            <i class="nc-icon nc-chart-bar-32"></i>
                            <span>Analytics</span>
                        </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="dropdown-item-form">
                            @csrf
                            <button type="submit" class="dropdown-item logout-btn">
                                <i class="nc-icon nc-button-power"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
.admin-navbar {
    position: fixed;
    top: 0;
    right: 0;
    left: 280px;
    height: 80px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    z-index: 999;
    transition: all 0.3s ease;
    margin-right: 0;
    box-sizing: border-box;
}

.navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 2rem;
    max-width: 100%;
}

/* Left Section */
.navbar-left {
    display: flex;
    align-items: center;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.brand-text {
    display: flex;
    flex-direction: column;
}

.brand-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d3748;
    line-height: 1;
}

.brand-subtitle {
    font-size: 0.75rem;
    color: #718096;
    font-weight: 500;
}

/* Center Section */
.navbar-center {
    flex: 1;
    display: flex;
    justify-content: center;
    margin: 0 2rem;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(102, 126, 234, 0.1);
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    border: 1px solid rgba(102, 126, 234, 0.2);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #4a5568;
}

.breadcrumb-item i {
    font-size: 1rem;
    color: #667eea;
}

.breadcrumb-item.active {
    color: #667eea;
    font-weight: 600;
}

.breadcrumb-separator {
    color: #a0aec0;
    font-size: 0.8rem;
}

/* Right Section */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.nav-item {
    position: relative;
}

/* Search */
.search-container {
    margin-right: 1rem;
}

.search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 300px;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.search-icon {
    position: absolute;
    left: 1rem;
    color: #a0aec0;
    font-size: 1rem;
}

/* Notifications */
.notification-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: rgba(102, 126, 234, 0.1);
    border: 1px solid rgba(102, 126, 234, 0.2);
    border-radius: 12px;
    color: #667eea;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.notification-btn:hover {
    background: rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #e53e3e;
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    min-width: 18px;
    text-align: center;
}

.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 350px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.1);
    margin-top: 0.5rem;
    z-index: 1000;
}

.dropdown-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dropdown-header h6 {
    margin: 0;
    font-weight: 600;
    color: #2d3748;
}

.notification-count {
    background: #667eea;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.notification-list {
    max-height: 300px;
    overflow-y: auto;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: background 0.3s ease;
}

.notification-item:hover {
    background: rgba(102, 126, 234, 0.05);
}

.notification-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.notification-icon.success {
    background: #48bb78;
}

.notification-icon.warning {
    background: #ed8936;
}

.notification-icon.info {
    background: #4299e1;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.notification-text {
    font-size: 0.8rem;
    color: #718096;
    margin-bottom: 0.25rem;
}

.notification-time {
    font-size: 0.75rem;
    color: #a0aec0;
}

.dropdown-footer {
    padding: 1rem 1.5rem;
    text-align: center;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.view-all-link {
    color: #667eea;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

.view-all-link:hover {
    text-decoration: underline;
}

/* User Menu */
.user-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1rem;
    background: rgba(102, 126, 234, 0.1);
    border: 1px solid rgba(102, 126, 234, 0.2);
    border-radius: 12px;
    color: #667eea;
    transition: all 0.3s ease;
    cursor: pointer;
}

.user-btn:hover {
    background: rgba(102, 126, 234, 0.2);
    transform: translateY(-2px);
}

.user-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.user-info {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.user-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d3748;
    line-height: 1;
}

.user-role {
    font-size: 0.75rem;
    color: #718096;
    line-height: 1;
}

.dropdown-arrow {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.user-btn:hover .dropdown-arrow {
    transform: rotate(180deg);
}

.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 280px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 0, 0, 0.1);
    margin-top: 0.5rem;
    z-index: 1000;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
}

.profile-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.profile-name {
    font-size: 1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.profile-email {
    font-size: 0.8rem;
    color: #718096;
}

.dropdown-body {
    padding: 0.5rem 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1.5rem;
    color: #4a5568;
    text-decoration: none;
    transition: background 0.3s ease;
    font-size: 0.9rem;
}

.dropdown-item:hover {
    background: rgba(102, 126, 234, 0.05);
    color: #667eea;
}

.dropdown-item i {
    font-size: 1rem;
    width: 20px;
    text-align: center;
}

.dropdown-divider {
    height: 1px;
    background: rgba(0, 0, 0, 0.1);
    margin: 0.5rem 0;
}

.dropdown-item-form {
    margin: 0;
}

.logout-btn {
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    color: #e53e3e;
}

.logout-btn:hover {
    background: rgba(229, 62, 62, 0.05);
    color: #e53e3e;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .search-input {
        width: 250px;
    }
    
    .navbar-center {
        margin: 0 1rem;
    }
}

@media (max-width: 768px) {
    .admin-navbar {
        left: 0;
    }
    
    .navbar-container {
        padding: 0 1rem;
    }
    
    .search-input {
        width: 200px;
    }
    
    .navbar-center {
        display: none;
    }
    
    .user-info {
        display: none;
    }
    
    .dropdown-arrow {
        display: none;
    }
}

@media (max-width: 480px) {
    .search-container {
        display: none;
    }
    
    .brand-subtitle {
        display: none;
    }
}

/* Fix for scrollbar overlap */
@media (min-width: 992px) {
    .admin-navbar {
        right: 0;
        width: calc(100vw - 280px - 17px);
    }
}

@media (max-width: 991px) {
    .admin-navbar {
        left: 0;
        width: 100%;
    }
}

/* Notification Loading State */
.notification-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 2rem;
    color: #718096;
    font-size: 0.9rem;
}

.notification-loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Notification Item Styles for Dynamic Content */
.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: background 0.3s ease;
    cursor: pointer;
}

.notification-item:hover {
    background: rgba(102, 126, 234, 0.05);
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item a {
    text-decoration: none;
    color: inherit;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    width: 100%;
}

.notification-icon {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.notification-icon.success {
    background: #48bb78;
}

.notification-icon.warning {
    background: #ed8936;
}

.notification-icon.info {
    background: #4299e1;
}

.notification-icon.error {
    background: #e53e3e;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.notification-text {
    font-size: 0.8rem;
    color: #718096;
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.notification-time {
    font-size: 0.75rem;
    color: #a0aec0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking for admin notification button...');
    
    // Only run for admin users
    if (document.getElementById('adminNotificationBtn')) {
        console.log('Admin notification button found, loading notifications...');
        loadAdminNotifications();
        
        // Refresh notifications every 30 seconds
        setInterval(loadAdminNotifications, 30000);
    } else {
        console.log('Admin notification button not found. User role might not be administrator.');
    }
});

function loadAdminNotifications() {
    console.log('Loading admin notifications...');
    
    const notificationList = document.getElementById('adminNotificationList');
    const notificationCount = document.getElementById('notificationCount');
    const notificationCountText = document.getElementById('notificationCountText');
    
    if (!notificationList) {
        console.error('Notification list element not found!');
        return;
    }
    
    // Show loading state
    notificationList.innerHTML = `
        <div class="notification-loading">
            <i class="nc-icon nc-refresh-69"></i>
            <span>Loading admin notifications...</span>
        </div>
    `;
    
    console.log('Fetching from:', '{{ route("admin.notifications") }}');
    
    // Fetch notifications from backend
    fetch('{{ route("admin.notifications") }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Received notification data:', data);
        
        // Update notification count
        const count = data.count || 0;
        notificationCount.textContent = count;
        notificationCountText.textContent = count + ' new';
        
        // Hide badge if no notifications
        if (count === 0) {
            notificationCount.style.display = 'none';
        } else {
            notificationCount.style.display = 'block';
        }
        
        // Render notifications
        if (data.notifications && data.notifications.length > 0) {
            notificationList.innerHTML = data.notifications.map(notification => `
                <div class="notification-item">
                    <a href="${notification.link || '#'}">
                        <div class="notification-icon ${notification.type}">
                            <i class="${notification.icon}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${notification.title}</div>
                            <div class="notification-text">${notification.text}</div>
                            <div class="notification-time">${notification.time}</div>
                        </div>
                    </a>
                </div>
            `).join('');
        } else {
            notificationList.innerHTML = `
                <div class="notification-loading">
                    <i class="nc-icon nc-check-2"></i>
                    <span>No new admin notifications</span>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error loading admin notifications:', error);
        notificationList.innerHTML = `
            <div class="notification-loading">
                <i class="nc-icon nc-alert-circle-i"></i>
                <span>Error loading admin notifications</span>
            </div>
        `;
    });
}
</script>