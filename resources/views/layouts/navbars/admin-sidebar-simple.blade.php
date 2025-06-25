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

                <!-- Analytics -->
                <li class="nav-item @if($activePage == 'analytics') active @endif">
                    <a class="nav-link" href="{{ route('admin.analytics') }}">
                        <div class="nav-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Analytics") }}</span>
                            <span class="nav-subtitle">Data insights</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
@import url('admin-sidebar.blade.php');
</style> 