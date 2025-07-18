<div class="vendor-sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
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
                    <p class="logo-subtitle">Vendor Panel</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="sidebar-nav">
            <ul class="nav-menu">
                <!-- Dashboard -->
                <li class="nav-item @if($activePage == 'dashboard') active @endif">
                    <a class="nav-link" href="{{route('vendor.dashboard')}}">
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
                <!-- Applications -->
                <li class="nav-item @if($activePage == 'applications') active @endif">
                    <a class="nav-link" href="{{route('vendor.applications.index')}}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-paper"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Applications") }}</span>
                            <span class="nav-subtitle">Your requests</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
                <!-- Reports -->
                <li class="nav-item @if($activePage == 'reports') active @endif">
                    <a class="nav-link" href="{{ route('vendor.reports') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-single-copy-04"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Reports") }}</span>
                            <span class="nav-subtitle">Download PDF</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
        </div>
    </div>
</div>

<style>
.vendor-sidebar {
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

.sidebar-footer {
    margin-top: auto;
    padding: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.logout-section {
    margin-bottom: 15px;
}

.logout-btn {
    width: 100%;
    background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    border: none;
    border-radius: 12px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    background: linear-gradient(135deg, #ff5252, #d32f2f);
}

.logout-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    color: white;
}

.logout-icon i {
    font-size: 14px;
}

.logout-content {
    flex: 1;
    text-align: left;
}

.logout-title {
    display: block;
    color: white;
    font-weight: 600;
    font-size: 14px;
    line-height: 1.2;
}

.logout-subtitle {
    display: block;
    color: rgba(255, 255, 255, 0.8);
    font-size: 11px;
    line-height: 1.2;
}

.admin-info {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.admin-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.admin-details {
    flex: 1;
}

.admin-name {
    display: block;
    color: white;
    font-weight: 600;
    font-size: 13px;
    line-height: 1.2;
}

.admin-role {
    display: block;
    color: rgba(255, 255, 255, 0.7);
    font-size: 11px;
    line-height: 1.2;
}

@media (max-width: 768px) {
    .vendor-sidebar {
        transform: translateX(-100%);
    }
    .vendor-sidebar.show {
        transform: translateX(0);
    }
}

.vendor-sidebar + .main-panel {
    width: calc(100% - 280px) !important;
    margin-left: 280px !important;
    padding-right: 0;
    box-sizing: border-box;
}

@media (max-width: 991px) {
    .vendor-sidebar + .main-panel {
        width: 100% !important;
        margin-left: 0 !important;
    }
}

.vendor-sidebar::-webkit-scrollbar {
    width: 4px;
}

.vendor-sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.vendor-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.vendor-sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style> 