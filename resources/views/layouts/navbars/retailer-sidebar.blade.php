<div class="admin-sidebar retailer-sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <div class="sidebar-overlay"></div>
    <div class="sidebar-wrapper">
        <!-- Logo Section -->
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="nc-icon nc-cart-simple"></i>
                </div>
                <div class="logo-text">
                    <h3 class="logo-title">BWSCMS</h3>
                    <p class="logo-subtitle">Retailer Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="sidebar-nav">
            <ul class="nav-menu">
                <!-- Dashboard -->
                <li class="nav-item @if($activePage == 'dashboard') active @endif">
                    <a class="nav-link" href="{{route('retailer.dashboard')}}">
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
                <!-- Orders -->
                <li class="nav-item @if($activePage == 'orders') active @endif">
                    <a class="nav-link" href="{{route('retailer.orders.index')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Orders") }}</span>
                            <span class="nav-subtitle">Manage orders</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <!-- Reports -->
                <li class="nav-item @if($activePage == 'reports') active @endif">
                    <a class="nav-link" href="{{route('retailer.reports.index')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Reports") }}</span>
                            <span class="nav-subtitle">Analytics & insights</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
.admin-sidebar.retailer-sidebar {
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
    font-size: 12px;
    margin: 0;
    font-weight: 400;
}

/* Navigation Section */
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
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 20px;
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
    .retailer-sidebar {
        transform: translateX(-100%);
    }
    
    .retailer-sidebar.show {
        transform: translateX(0);
    }
}

/* Fix main panel width for retailer sidebar */
.retailer-sidebar + .main-panel {
    width: calc(100% - 280px) !important;
    margin-left: 280px !important;
    /* Account for scrollbar */
    padding-right: 0;
    box-sizing: border-box;
}

@media (max-width: 991px) {
    .retailer-sidebar + .main-panel {
        width: 100% !important;
        margin-left: 0 !important;
    }
}

/* Scrollbar Styling */
.retailer-sidebar::-webkit-scrollbar {
    width: 4px;
}

.retailer-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.retailer-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.retailer-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style> 