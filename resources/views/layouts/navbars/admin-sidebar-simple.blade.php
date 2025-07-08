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
        <div style="color: red; font-weight: bold;">TEST: admin-sidebar-simple.blade.php</div>
        <div style="color: orange; font-weight: bold;">TEST: admin-sidebar-simple.blade.php - QUICK ACTIONS SHOULD BE VISIBLE</div>

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
                <!-- Quick Actions -->
                <li class="nav-section">
                    <span class="nav-section-title">Quick Actions</span>
                </li>
                <!-- Notifications -->
                <li class="nav-item @if($activePage == 'notifications') active @endif">
                    <a class="nav-link" href="{{ route('admin.notifications') }}">
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