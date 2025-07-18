<div class="admin-sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <div class="sidebar-overlay"></div>
    <div class="sidebar-wrapper">
        <!-- Logo Section -->
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="nc-icon nc-drop"></i>
                </div>
                <div class="logo-text">
                    <h3 class="logo-title">BWSCMS</h3>
                    <p class="logo-subtitle">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="sidebar-nav">
            <ul class="nav-menu">
                <!-- Dashboard Overview -->
                <li class="nav-item @if($activePage == 'dashboard-overview') active @endif">
                    <a class="nav-link" href="{{route('admin.dashboard')}}">
                            <div class="nav-icon">
                        <i class="nc-icon nc-chart-pie-35"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("Dashboard Overview") }}</span>
                                <span class="nav-subtitle">System overview</span>
                            </div>
                            <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-item @if($activePage == 'user-management') active @endif">
                    <a class="nav-link" href="{{route('admin.users.index')}}">
                            <div class="nav-icon">
                        <i class="nc-icon nc-circle-09"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("User Management") }}</span>
                                <span class="nav-subtitle">Manage users</span>
                            </div>
                            <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Task Management -->
                <li class="nav-item @if($activePage == 'work-distribution') active @endif">
                    <a class="nav-link" href="{{ route('admin.work-distribution.index') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-briefcase-24"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Work Distribution") }}</span>
                            <span class="nav-subtitle">Manage work assignments</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Task Scheduling -->
                <li class="nav-item @if($activePage == 'task-scheduling') active @endif">
                    <a class="nav-link" href="{{ route('admin.tasks.index') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-calendar-60"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Task Scheduling") }}</span>
                            <span class="nav-subtitle">Schedule and track tasks</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Task Reports -->
                <li class="nav-item @if($activePage == 'task-reports') active @endif">
                    <a class="nav-link" href="{{ route('admin.tasks.reports') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Task Reports") }}</span>
                            <span class="nav-subtitle">View task analytics</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Admin Reports (PDF Download) -->
                <li class="nav-item @if($activePage == 'admin-reports') active @endif">
                    <a class="nav-link" href="{{ route('admin.reports') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-single-copy-04"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Reports") }}</span>
                            <span class="nav-subtitle">Download admin report</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Vendor Applications -->
                <li class="nav-item @if($activePage == 'vendor-applications') active @endif">
                    <a class="nav-link" href="{{route('admin.vendors.applications')}}">
                            <div class="nav-icon">
                        <i class="nc-icon nc-paper"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("Vendor Applications") }}</span>
                                <span class="nav-subtitle">Review applications</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>

                <!-- Demand Forecast -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.analytics.demand-forecast') }}">
                        <i class="nc-icon nc-chart-bar-32"></i>
                        <p>Demand Forecast</p>
                    </a>
                </li>

                <!-- Customer Segmentation -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.analytics.customer-segmentation') }}">
                        <i class="nc-icon nc-single-02"></i>
                        <p>Customer Segmentation</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div style="color: blue; font-weight: bold;">TEST: admin-sidebar.blade.php</div>

<style>
.admin-sidebar {
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
    padding: 2rem 1.5rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logo-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.logo-icon i {
    font-size: 1.5rem;
    color: white;
}

.logo-text {
    flex: 1;
}

.logo-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0;
    letter-spacing: -0.5px;
}

.logo-subtitle {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
    font-weight: 500;
}

/* Navigation Section */
.sidebar-nav {
    flex: 1;
    padding: 1.5rem 0;
}

.nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    margin: 0.5rem 1rem;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    transform: translateX(5px);
}

.nav-item.active .nav-link {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.nav-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.nav-icon i {
    font-size: 1.2rem;
    color: inherit;
}

.nav-item.active .nav-icon {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.nav-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.nav-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: inherit;
    margin: 0;
}

.nav-subtitle {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
    font-weight: 400;
}

.nav-indicator {
    width: 4px;
    height: 20px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
    transition: all 0.3s ease;
}

.nav-item.active .nav-indicator {
    background: white;
    height: 30px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-sidebar {
        transform: translateX(-100%);
    }
    
    .admin-sidebar.show {
        transform: translateX(0);
    }
}

/* Fix main panel width for BWSCMSidebar */
.admin-sidebar + .main-panel {
    width: calc(100% - 280px) !important;
    margin-left: 280px !important;
    /* Account for scrollbar */
    padding-right: 0;
    box-sizing: border-box;
}

@media (max-width: 991px) {
    .admin-sidebar + .main-panel {
        width: 100% !important;
        margin-left: 0 !important;
    }
}

/* Scrollbar Styling */
.admin-sidebar::-webkit-scrollbar {
    width: 4px;
}

.admin-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.admin-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.admin-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style> 