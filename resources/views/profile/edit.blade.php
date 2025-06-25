@extends('layouts.app', ['activePage' => 'user', 'title' => 'User Profile'])

@section('content')
    <div class="content">
        <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">User Profile & Settings</h1>
                        <p class="welcome-subtitle">Manage your account information, update your details, and change your password</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-single-02"></i>
                    </div>
                </div>
                                </div>
        </div>

        <div class="row">
            <!-- Profile Information Card -->
            <div class="col-lg-8 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Profile Information</h4>
                            <p class="card-subtitle">Update your personal details and account information</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-single-02"></i>
                            </div>
                        </div>
                        <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                
                                @include('alerts.success')
                                @include('alerts.error_self_update', ['key' => 'not_allow_profile'])
        
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="nc-icon nc-single-02"></i>
                                    User Information
                                </h6>
                                
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">
                                        <i class="nc-icon nc-single-02"></i>
                                        {{ __('Name') }}
                                        </label>
                                    <input type="text" name="name" id="input-name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter your full name') }}" value="{{ old('name', auth()->user()->name) }}" required autofocus>
                                        @include('alerts.feedback', ['field' => 'name'])
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">
                                        <i class="nc-icon nc-email-85"></i>
                                        {{ __('Email') }}
                                    </label>
                                    <input type="email" name="email" id="input-email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter your email address') }}" value="{{ old('email', auth()->user()->email) }}" required>
                                        @include('alerts.feedback', ['field' => 'email'])
                                    </div>

                                <div class="form-actions">
                                    <button type="submit" class="save-btn">
                                        <i class="nc-icon nc-check-2"></i>
                                        <span>{{ __('Save Changes') }}</span>
                                    </button>
                                    </div>
                                </div>
                            </form>

                        <div class="divider"></div>

                            <form method="post" action="{{ route('profile.password') }}">
                                @csrf
                                @method('patch')
        
                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="nc-icon nc-lock-circle"></i>
                                    Password Settings
                                </h6>
        
                                @include('alerts.success', ['key' => 'password_status'])
                                @include('alerts.error_self_update', ['key' => 'not_allow_password'])
        
                                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-current-password">
                                        <i class="nc-icon nc-lock-circle"></i>
                                        {{ __('Current Password') }}
                                        </label>
                                    <input type="password" name="old_password" id="input-current-password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter your current password') }}" value="" required>
                                        @include('alerts.feedback', ['field' => 'old_password'])
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-password">
                                        <i class="nc-icon nc-key-25"></i>
                                        {{ __('New Password') }}
                                        </label>
                                    <input type="password" name="password" id="input-password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Enter your new password') }}" value="" required>
                                        @include('alerts.feedback', ['field' => 'password'])
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label" for="input-password-confirmation">
                                        <i class="nc-icon nc-key-25"></i>
                                        {{ __('Confirm New Password') }}
                                        </label>
                                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control" placeholder="{{ __('Confirm your new password') }}" value="" required>
                                    </div>
        
                                <div class="form-actions">
                                    <button type="submit" class="save-btn">
                                        <i class="nc-icon nc-check-2"></i>
                                        <span>{{ __('Change Password') }}</span>
                                    </button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>

            <!-- User Profile Card -->
            <div class="col-lg-4 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Profile Overview</h4>
                            <p class="card-subtitle">Your account information and status</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-pie-35"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="profile-overview">
                            <div class="profile-avatar">
                                <div class="avatar-container">
                                    <i class="nc-icon nc-single-02"></i>
                        </div>
                    </div>

                            <div class="profile-info">
                                <h5 class="profile-name">{{ auth()->user()->name }}</h5>
                                <p class="profile-email">{{ auth()->user()->email }}</p>
                                <div class="profile-role">
                                    <span class="role-badge">
                                        <i class="nc-icon nc-cart-simple"></i>
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                            </div>

                            <div class="profile-stats">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="nc-icon nc-calendar-60"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-label">Member Since</span>
                                        <span class="stat-value">{{ auth()->user()->created_at->format('M Y') }}</span>
                                    </div>
                                </div>
                                
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <i class="nc-icon nc-time-alarm"></i>
                                    </div>
                                    <div class="stat-content">
                                        <span class="stat-label">Last Updated</span>
                                        <span class="stat-value">{{ auth()->user()->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-actions">
                                <div class="action-item">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                    <span>Account Settings</span>
                                </div>
                                <div class="action-item">
                                    <i class="nc-icon nc-bell-55"></i>
                                    <span>Notifications</span>
                                </div>
                                <div class="action-item">
                                    <i class="nc-icon nc-shield"></i>
                                    <span>Privacy & Security</span>
                                </div>
                            </div>
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
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    border-radius: 20px;
    padding: 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.welcome-content {
    flex: 1;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.welcome-subtitle {
    font-size: 1.1rem;
    margin: 0;
    opacity: 0.9;
    font-weight: 400;
}

.welcome-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 30px;
}

.welcome-icon i {
    font-size: 40px;
    color: white;
}

/* Content Cards */
.content-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: 100%;
}

.card-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: white;
}

.header-content {
    flex: 1;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 5px 0;
    line-height: 1.2;
}

.card-subtitle {
    font-size: 0.95rem;
    margin: 0;
    opacity: 0.9;
    font-weight: 400;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 20px;
}

.header-icon i {
    font-size: 24px;
    color: white;
}

.card-body {
    padding: 30px;
}

/* Form Styling */
.form-section {
    margin-bottom: 30px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid rgba(25, 118, 210, 0.1);
}

.section-title i {
    font-size: 20px;
    color: #1976d2;
}

.form-group {
    margin-bottom: 25px;
}

.form-control-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.form-control-label i {
    font-size: 16px;
    color: #1976d2;
}

.form-control {
    border: 2px solid rgba(25, 118, 210, 0.1);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.form-control:focus {
    border-color: #1976d2;
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    background: white;
}

.form-control::placeholder {
    color: #999;
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.invalid-feedback::before {
    content: "⚠";
    font-size: 14px;
}

/* Form Actions */
.form-actions {
    margin-top: 30px;
}

.save-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.save-btn i {
    font-size: 18px;
}

/* Divider */
.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(25, 118, 210, 0.2), transparent);
    margin: 40px 0;
}

/* Profile Overview */
.profile-overview {
    text-align: center;
}

.profile-avatar {
    margin-bottom: 25px;
}

.avatar-container {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.avatar-container i {
    font-size: 40px;
    color: white;
}

.profile-info {
    margin-bottom: 30px;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 5px 0;
}

.profile-email {
    font-size: 1rem;
    color: #666;
    margin: 0 0 15px 0;
}

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.role-badge i {
    font-size: 14px;
}

/* Profile Stats */
.profile-stats {
    margin-bottom: 30px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    margin-bottom: 10px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon i {
    font-size: 18px;
    color: white;
}

.stat-content {
    flex: 1;
    text-align: left;
}

.stat-label {
    display: block;
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 2px;
}

.stat-value {
    display: block;
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
}

/* Profile Actions */
.profile-actions {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    padding-top: 20px;
}

.action-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.action-item:hover {
    background: rgba(25, 118, 210, 0.1);
    transform: translateX(5px);
}

.action-item i {
    font-size: 18px;
    color: #1976d2;
    width: 20px;
}

.action-item span {
    font-size: 0.95rem;
    color: #333;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        padding-top: 120px !important;
    }
    
    .welcome-card {
        flex-direction: column;
        text-align: center;
        padding: 30px 20px;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .welcome-icon {
        margin: 20px 0 0 0;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .header-icon {
        margin: 0;
    }
    
    .stat-item {
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }
    
    .stat-content {
        text-align: center;
    }
}
</style>
@endsection