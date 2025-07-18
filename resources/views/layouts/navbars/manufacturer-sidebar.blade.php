<div class="manufacturer-sidebar">
    <div class="sidebar-overlay"></div>
    <div class="sidebar-wrapper">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="nc-icon nc-settings-gear-65"></i>
                </div>
                <div class="logo-text">
                    <h4 class="logo-title">BWSCMS</h4>
                    <p class="logo-subtitle">Manufacturer Portal</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="sidebar-nav">
            <ul class="nav-menu">
                <!-- Dashboard -->
                <li class="nav-item @if($activePage == 'dashboard') active @endif">
                    <a class="nav-link" href="{{route('manufacturer.dashboard')}}">
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

                <!-- Production -->
                <li class="nav-item @if($activePage == 'production') active @endif">
                    <a class="nav-link" href="{{route('manufacturer.production.batches')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Production") }}</span>
                            <span class="nav-subtitle">Manage batches</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Inventory -->
                <li class="nav-item @if($activePage == 'inventory') active @endif">
                    <a class="nav-link" href="{{route('manufacturer.inventory.index')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-box-2"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Inventory") }}</span>
                            <span class="nav-subtitle">Stock management</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Raw Material Orders -->
                <li class="nav-item @if($activePage == 'raw-material-orders') active @endif">
                    <a class="nav-link" href="{{route('manufacturer.raw-material-orders')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Raw Material Orders") }}</span>
                            <span class="nav-subtitle">Order from suppliers</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item @if($activePage == 'orders') active @endif">
                    <a class="nav-link" href="{{route('manufacturer.orders')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-cart-simple"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Orders") }}</span>
                            <span class="nav-subtitle">Process & track orders</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item @if($activePage == 'notifications') active @endif">
                    <a class="nav-link" href="{{route('manufacturer.notifications')}}">
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

<<<<<<< HEAD
                <!-- Reports -->
                <li class="nav-item @if($activePage == 'reports') active @endif">
                    <a class="nav-link" href="{{ route('manufacturer.reports') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Reports") }}</span>
                            <span class="nav-subtitle">Production & Inventory</span>
=======
                <!-- Assigned Tasks -->
                <li class="nav-item @if($activePage == 'assigned-tasks') active @endif">
                    <a class="nav-link" href="{{ route('manufacturer.tasks.assigned') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-bullet-list-67"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">Assigned Tasks</span>
                            <span class="nav-subtitle">Respond to assignments</span>
>>>>>>> 53b55260038ec1088546a0789b7243a4938e5444
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>

<<<<<<< HEAD
                <!-- Chat Page -->
                <li class="nav-item @if($activePage == 'chat') active @endif">
                    <a class="nav-link" href="{{ route('manufacturer.chats.index') }}">
=======
                <!-- Static Chat Page -->
                <li class="nav-item @if($activePage == 'static-chat') active @endif">
                    <a class="nav-link" href="/manufacturer/static-chat">
>>>>>>> 53b55260038ec1088546a0789b7243a4938e5444
                        <div class="nav-icon">
                            <i class="nc-icon nc-chat-33"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Chat") }}</span>
                            <span class="nav-subtitle">Suppliers & Orders</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
.manufacturer-sidebar {
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
    min-width: 0;
}

.nav-title {
    display: block;
    font-weight: 600;
    font-size: 0.95rem;
    color: white;
    margin-bottom: 2px;
}

.nav-subtitle {
    display: block;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 400;
}

.nav-indicator {
    width: 6px;
    height: 6px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.nav-item.active .nav-indicator {
    background: white;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

/* Responsive Design */
@media (max-width: 768px) {
    .manufacturer-sidebar {
        transform: translateX(-100%);
    }
    
    .manufacturer-sidebar.show {
        transform: translateX(0);
    }
}

@media (max-width: 576px) {
    .manufacturer-sidebar {
        width: 260px;
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
}
</style> 