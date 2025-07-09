<div class="modern-sidebar">
    <div class="sidebar-wrapper">
        <!-- Logo Section -->
        <div class="sidebar-logo">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="logo-text">
                    <h3>BWSCMS</h3>
                    
                </div>
            </div>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <!-- Dashboard Overview - Admin Only -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <li class="nav-item @if($activePage == 'dashboard-overview') active @endif">
                        <a class="nav-link" href="{{route('admin.dashboard')}}">
                            <div class="nav-icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("Dashboard Overview") }}</span>
                                <span class="nav-subtitle">Admin analytics</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif

<<<<<<< HEAD
                <!-- Main Dashboard -->
                <li class="nav-item @if($activePage == 'dashboard') active @endif">
                    <a class="nav-link" href="@if(Auth::user() && Auth::user()->role == 'administrator'){{ route('admin.dashboard') }}@elseif(Auth::user() && Auth::user()->role == 'manufacturer'){{ route('manufacturer.dashboard') }}@elseif(Auth::user() && Auth::user()->role == 'supplier'){{ route('supplier.dashboard') }}@elseif(Auth::user() && Auth::user()->role == 'retailer'){{ route('retailer.dashboard') }}@else#@endif">
                        <div class="nav-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="nav-content">
                            <span class="nav-title">{{ __("Dashboard") }}</span>
                            <span class="nav-subtitle">Main overview</span>
                        </div>
                        <div class="nav-indicator"></div>
                    </a>
                </li>
=======
                @if(auth()->check() && auth()->user()->role === 'vendor')
                    <li class="nav-item @if($activePage == 'dashboard') active @endif">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <div class="nav-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("Vendor Dashboard") }}</span>
                                <span class="nav-subtitle">Vendor overview</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif

                @if(auth()->check() && auth()->user()->role === 'supplier')
                    <li class="nav-item @if($activePage == 'dashboard') active @endif">
                        <a class="nav-link" href="{{route('dashboard')}}">
                            <div class="nav-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("Supplier Dashboard") }}</span>
                                <span class="nav-subtitle">Supplier overview</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif

                @if(auth()->check() && auth()->user()->role === 'manufacturer')
                    <li class="nav-item @if($activePage == 'dashboard') active @endif">
                        <a class="nav-link" href="{{route('manufacturer.dashboard')}}">
                            <div class="nav-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("Manufacturer Dashboard") }}</span>
                                <span class="nav-subtitle">Manufacturer overview</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif

                @if(auth()->check() && auth()->user()->role === 'retailer')
                    <li class="nav-item @if($activePage == 'dashboard') active @endif">
                        <a class="nav-link" href="{{route('retailer.dashboard')}}">
                            <div class="nav-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">{{ __("Retailer Dashboard") }}</span>
                                <span class="nav-subtitle">Retailer overview</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif
>>>>>>> 7f70518c631fbc42ad89ee760eefde5382a63c08

                <!-- Section Divider -->
                <li class="nav-divider">
                    
                </li>

                <!-- Additional Admin Menu Items -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <!-- Quick Actions Section -->
                    <li class="nav-section">
                        <span class="nav-section-title">Quick Actions</span>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.notifications') }}">
                            <div class="nav-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Notifications</span>
                                <span class="nav-subtitle">System alerts</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tasks.reports') }}">
                            <div class="nav-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Task Reports</span>
                                <span class="nav-subtitle">View task analytics</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.vendors.applications') }}">
                            <div class="nav-icon">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Vendor Applications</span>
                                <span class="nav-subtitle">Review requests</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            <div class="nav-icon">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">User Management</span>
                                <span class="nav-subtitle">Manage users</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif
                @if(auth()->check() && auth()->user()->role === 'vendor')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports') }}">
                            <div class="nav-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Reports</span>
                                <span class="nav-subtitle">Vendor reports</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif
                @if(auth()->check() && auth()->user()->role === 'supplier')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('supplier.notifications') }}">
                            <div class="nav-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Notifications</span>
                                <span class="nav-subtitle">Supplier alerts</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif
                @if(auth()->check() && auth()->user()->role === 'manufacturer')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manufacturer.notifications') }}">
                            <div class="nav-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Notifications</span>
                                <span class="nav-subtitle">Manufacturer alerts</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manufacturer.analytics') }}">
                            <div class="nav-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Analytics</span>
                                <span class="nav-subtitle">Production analytics</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif
                @if(auth()->check() && auth()->user()->role === 'retailer')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('retailer.reports.index') }}">
                            <div class="nav-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="nav-content">
                                <span class="nav-title">Reports</span>
                                <span class="nav-subtitle">Retailer reports</span>
                            </div>
                            <div class="nav-indicator"></div>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- User Info Section -->
        {{-- User Info removed --}}

        <!-- Sidebar Footer -->
        {{-- Logout/Sign out removed --}}
    </div>
</div>

<div style="color: green; font-weight: bold;">TEST: sidebar.blade.php</div>

<style>
/* Modern Sidebar Styles */
.modern-sidebar {
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
    border-right: 1px solid #e2e8f0;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1000;
    overflow: hidden;
    transition: all 0.3s ease;
}

.sidebar-wrapper {
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
}

/* Logo Section */
.sidebar-logo {
    padding: 2rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.sidebar-logo::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
}

.logo-icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.logo-text h3 {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    line-height: 1;
}

.logo-text span {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    padding: 1.5rem 0;
    overflow-y: auto;
    overflow-x: hidden;
}

.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 2px;
}

.nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    margin: 0.25rem 1rem;
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    text-decoration: none;
    color: #4a5568;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    transition: width 0.3s ease;
    z-index: -1;
}

.nav-link:hover {
    color: #2d3748;
    background: rgba(102, 126, 234, 0.05);
    transform: translateX(5px);
    text-decoration: none;
}

.nav-link:hover::before {
    width: 4px;
}

.nav-item.active .nav-link {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    color: #667eea;
    border-left: 4px solid #667eea;
    margin-left: -4px;
    padding-left: 1.5rem;
}

.nav-item.active .nav-link::before {
    width: 4px;
}

.nav-icon {
    width: 40px;
    height: 40px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #667eea;
    transition: all 0.3s ease;
    position: relative;
}

.nav-item.active .nav-icon,
.nav-link:hover .nav-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    transform: scale(1.05);
}

.nav-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}

.nav-title {
    font-weight: 600;
    font-size: 0.95rem;
    line-height: 1.2;
}

.nav-subtitle {
    font-size: 0.75rem;
    color: #a0aec0;
    font-weight: 500;
}

.nav-item.active .nav-subtitle {
    color: rgba(102, 126, 234, 0.7);
}

.nav-indicator {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: transparent;
    transition: all 0.3s ease;
}

.nav-item.active .nav-indicator {
    background: #667eea;
    box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
}

/* Notification Badge */
.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    width: 18px;
    height: 18px;
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
    border-radius: 50%;
    font-size: 0.7rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
    animation: pulse 2s infinite;
}

/* Section Divider */
.nav-divider {
    padding: 1rem 1.5rem 0.5rem;
    margin-top: 1rem;
    position: relative;
}

.nav-divider::before {
    content: '';
    position: absolute;
    top: 0;
    left: 1.5rem;
    right: 1.5rem;
    height: 1px;
    background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
}

.nav-divider span {
    font-size: 0.75rem;
    font-weight: 600;
    color: #a0aec0;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

/* User Section */
.sidebar-user {
    padding: 1.5rem;
    border-top: 1px solid #e2e8f0;
    background: linear-gradient(135deg, #f8fafc, #ffffff);
}

.user-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.user-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.user-avatar {
    position: relative;
}

.user-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #e2e8f0;
}

.user-status {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.user-status.online {
    background: #48bb78;
}

.user-info {
    flex: 1;
}

.user-info h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 0.2rem 0;
    line-height: 1.2;
}

.user-info span {
    font-size: 0.75rem;
    color: #718096;
    text-transform: capitalize;
}

.user-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 32px;
    height: 32px;
    border: none;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.8rem;
}

.action-btn:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    transform: scale(1.05);
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(5deg); }
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(240, 147, 251, 0.7); }
    70% { box-shadow: 0 0 0 5px rgba(240, 147, 251, 0); }
    100% { box-shadow: 0 0 0 0 rgba(240, 147, 251, 0); }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .modern-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .modern-sidebar.open {
        transform: translateX(0);
    }
}

@media (max-width: 768px) {
    .modern-sidebar {
        width: 260px;
    }
    
    .sidebar-logo {
        padding: 1.5rem 1rem;
    }
    
    .nav-item {
        margin: 0.25rem 0.75rem;
    }
    
    .nav-link {
        padding: 0.875rem 1rem;
    }
    
    .sidebar-user {
        padding: 1rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .modern-sidebar {
        background: linear-gradient(180deg, #1a202c 0%, #2d3748 100%);
        border-right-color: #4a5568;
    }
    
    .nav-link {
        color: #e2e8f0;
    }
    
    .nav-link:hover {
        color: #f7fafc;
        background: rgba(102, 126, 234, 0.15);
    }
    
    .nav-subtitle {
        color: #718096;
    }
    
    .user-card {
        background: #2d3748;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    .user-info h4 {
        color: #f7fafc;
    }
    
    .user-info span {
        color: #cbd5e0;
    }
}

/* Custom scrollbar for webkit browsers */
.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

/* Focus states for accessibility */
.nav-link:focus,
.action-btn:focus {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .modern-sidebar {
        display: none;
    }
}
</style>