@extends('layouts.app', ['activePage' => 'notifications', 'title' => 'Manufacturer Notifications'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Manufacturing Notifications</h1>
                        <p class="welcome-subtitle">Stay updated with production alerts, inventory warnings, and system notifications</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-bell-55"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">24</h3>
                        <p class="stats-label">Total Notifications</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>This month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-alert-circle-i"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">8</h3>
                        <p class="stats-label">Unread Alerts</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Require attention</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-check-2"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">16</h3>
                        <p class="stats-label">Resolved Issues</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>This month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-time-alarm"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">2.3h</h3>
                        <p class="stats-label">Avg Response Time</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>To alerts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Management -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Notification Center</h4>
                            <p class="card-subtitle">Manage and respond to system alerts and production notifications</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-bell-55"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter Controls -->
                        <div class="filter-section">
                            <div class="filter-controls">
                                <div class="filter-group">
                                    <label class="filter-label">Filter by:</label>
                                    <select class="filter-select" id="statusFilter">
                                        <option value="all">All Notifications</option>
                                        <option value="unread">Unread Only</option>
                                        <option value="read">Read Only</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label class="filter-label">Type:</label>
                                    <select class="filter-select" id="typeFilter">
                                        <option value="all">All Types</option>
                                        <option value="warning">Warnings</option>
                                        <option value="success">Success</option>
                                        <option value="info">Information</option>
                                        <option value="error">Errors</option>
                                    </select>
                                </div>
                            </div>
                            <div class="action-buttons">
                                <button class="action-btn mark-all-read">
                                    <i class="nc-icon nc-check-2"></i>
                                    Mark All Read
                                </button>
                                <button class="action-btn clear-all">
                                    <i class="nc-icon nc-simple-remove"></i>
                                    Clear All
                                </button>
                            </div>
                        </div>

                        <!-- Notifications List -->
                        <div class="notifications-list">
                            <!-- Unread Notification -->
                            <div class="notification-item unread warning">
                                <div class="notification-icon">
                                    <i class="nc-icon nc-alert-circle-i"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Low Inventory Alert</h6>
                                        <div class="notification-meta">
                                            <span class="notification-time">2 hours ago</span>
                                            <span class="notification-priority high">High Priority</span>
                                        </div>
                                    </div>
                                    <p class="notification-message">Plastic bottles inventory is running low. Current stock: 1,250 units. Reorder recommended to maintain production schedule.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn small primary">Reorder Now</button>
                                        <button class="action-btn small secondary">View Details</button>
                                        <button class="action-btn small mark-read">Mark Read</button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <div class="unread-indicator"></div>
                                </div>
                            </div>

                            <!-- Read Notification -->
                            <div class="notification-item read success">
                                <div class="notification-icon">
                                    <i class="nc-icon nc-check-2"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Production Target Achieved</h6>
                                        <div class="notification-meta">
                                            <span class="notification-time">1 day ago</span>
                                            <span class="notification-priority medium">Medium Priority</span>
                                        </div>
                                    </div>
                                    <p class="notification-message">Monthly production target of 15,000 units has been achieved ahead of schedule. Great work team!</p>
                                    <div class="notification-actions">
                                        <button class="action-btn small secondary">View Report</button>
                                        <button class="action-btn small">Share</button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <div class="read-indicator"></div>
                                </div>
                            </div>

                            <!-- Information Notification -->
                            <div class="notification-item unread info">
                                <div class="notification-icon">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-header">
                                        <h6 class="notification-title">Efficiency Report Available</h6>
                                        <div class="notification-meta">
                                            <span class="notification-time">3 days ago</span>
                                            <span class="notification-priority low">Low Priority</span>
                                        </div>
                                    </div>
                                    <p class="notification-message">Weekly efficiency report is now available. Production efficiency increased by 8.2% compared to last week.</p>
                                    <div class="notification-actions">
                                        <button class="action-btn small primary">View Report</button>
                                        <button class="action-btn small mark-read">Mark Read</button>
                                    </div>
                                </div>
                                <div class="notification-status">
                                    <div class="unread-indicator"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Notification Settings</h4>
                            <p class="card-subtitle">Configure your notification preferences</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-settings-gear-65"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-content">
                                    <h6 class="setting-title">Production Alerts</h6>
                                    <p class="setting-description">Get notified about production issues and milestones</p>
                                </div>
                                <div class="setting-toggle">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-content">
                                    <h6 class="setting-title">Inventory Warnings</h6>
                                    <p class="setting-description">Receive alerts when stock levels are low</p>
                                </div>
                                <div class="setting-toggle">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-content">
                                    <h6 class="setting-title">Equipment Maintenance</h6>
                                    <p class="setting-description">Notifications for scheduled maintenance</p>
                                </div>
                                <div class="setting-toggle">
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="content-card">
                    <div class="card-header">
                        <div class="header-content">
                            <h4 class="card-title">Recent Activity</h4>
                            <p class="card-subtitle">Latest system activities and updates</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="nc-icon nc-box-2"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-title">New Production Batch Started</h6>
                                    <p class="activity-description">Batch #2024-001 initiated for 500ml bottles</p>
                                    <span class="activity-time">30 minutes ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="nc-icon nc-check-2"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-title">Quality Check Completed</h6>
                                    <p class="activity-description">Batch #2023-045 passed all quality tests</p>
                                    <span class="activity-time">2 hours ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="nc-icon nc-time-alarm"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-title">Maintenance Scheduled</h6>
                                    <p class="activity-description">Equipment maintenance scheduled for tomorrow</p>
                                    <span class="activity-time">4 hours ago</span>
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 40px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
    margin-bottom: 30px;
}

.welcome-content {
    flex: 1;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
    font-weight: 300;
}

.welcome-icon {
    font-size: 4rem;
    opacity: 0.8;
    margin-left: 30px;
}

/* Statistics Cards */
.stats-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 5px;
}

.stats-label {
    font-size: 1rem;
    color: #7f8c8d;
    margin-bottom: 15px;
    font-weight: 500;
}

.stats-footer {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    color: #95a5a6;
}

.stats-footer i {
    margin-right: 8px;
    font-size: 0.9rem;
}

/* Content Cards */
.content-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    overflow: hidden;
    margin-bottom: 30px;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-content h4 {
    margin: 0;
    font-size: 1.4rem;
    font-weight: 600;
}

.header-content p {
    margin: 5px 0 0 0;
    opacity: 0.9;
    font-size: 0.95rem;
}

.header-icon {
    font-size: 2rem;
    opacity: 0.8;
}

.card-body {
    padding: 30px;
}

/* Filter Section */
.filter-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.filter-controls {
    display: flex;
    gap: 20px;
    align-items: center;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.filter-select {
    padding: 8px 12px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background: white;
    font-size: 0.9rem;
    color: #2c3e50;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.action-btn {
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.action-btn.mark-all-read {
    background: #27ae60;
    color: white;
}

.action-btn.clear-all {
    background: #e74c3c;
    color: white;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Notifications List */
.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
}

.notification-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.notification-item.unread {
    border-left: 4px solid #667eea;
    background: rgba(102, 126, 234, 0.05);
}

.notification-item.warning {
    border-left: 4px solid #f39c12;
}

.notification-item.success {
    border-left: 4px solid #27ae60;
}

.notification-item.info {
    border-left: 4px solid #3498db;
}

.notification-item.error {
    border-left: 4px solid #e74c3c;
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    flex-shrink: 0;
}

.notification-item.warning .notification-icon {
    background: #f39c12;
}

.notification-item.success .notification-icon {
    background: #27ae60;
}

.notification-item.info .notification-icon {
    background: #3498db;
}

.notification-item.error .notification-icon {
    background: #e74c3c;
}

.notification-content {
    flex: 1;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.notification-title {
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    font-size: 1.1rem;
}

.notification-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
}

.notification-time {
    font-size: 0.8rem;
    color: #95a5a6;
}

.notification-priority {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.notification-priority.high {
    background: #e74c3c;
    color: white;
}

.notification-priority.medium {
    background: #f39c12;
    color: white;
}

.notification-priority.low {
    background: #27ae60;
    color: white;
}

.notification-message {
    color: #7f8c8d;
    font-size: 0.95rem;
    margin-bottom: 15px;
    line-height: 1.5;
}

.notification-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.action-btn.small {
    padding: 6px 12px;
    font-size: 0.8rem;
}

.action-btn.primary {
    background: #667eea;
    color: white;
}

.action-btn.secondary {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    border: 1px solid #667eea;
}

.action-btn.mark-read {
    background: #27ae60;
    color: white;
}

.notification-status {
    display: flex;
    align-items: center;
}

.unread-indicator {
    width: 12px;
    height: 12px;
    background: #667eea;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.read-indicator {
    width: 12px;
    height: 12px;
    background: #95a5a6;
    border-radius: 50%;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
    }
}

/* Settings List */
.settings-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.setting-content {
    flex: 1;
}

.setting-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
    font-size: 1rem;
}

.setting-description {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin: 0;
}

/* Toggle Switch */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #667eea;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

/* Activity List */
.activity-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: rgba(255, 255, 255, 0.95);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.activity-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: white;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.activity-description {
    color: #7f8c8d;
    font-size: 0.85rem;
    margin-bottom: 5px;
}

.activity-time {
    font-size: 0.75rem;
    color: #95a5a6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-card {
        flex-direction: column;
        text-align: center;
        padding: 30px 20px;
    }
    
    .welcome-icon {
        margin-left: 0;
        margin-top: 20px;
        font-size: 3rem;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .stats-card {
        padding: 20px;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .filter-section {
        flex-direction: column;
        gap: 20px;
    }
    
    .filter-controls {
        flex-direction: column;
        width: 100%;
    }
    
    .filter-group {
        width: 100%;
        justify-content: space-between;
    }
    
    .filter-select {
        flex: 1;
        margin-left: 10px;
    }
    
    .action-buttons {
        width: 100%;
        justify-content: center;
    }
    
    .notification-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .notification-meta {
        align-items: flex-start;
    }
    
    .notification-actions {
        justify-content: flex-start;
    }
}

@media (max-width: 576px) {
    .content {
        padding-top: 80px !important;
    }
    
    .welcome-title {
        font-size: 1.8rem;
    }
    
    .stats-card {
        padding: 15px;
    }
    
    .card-body {
        padding: 20px;
    }
    
    .notification-item {
        padding: 20px;
    }
    
    .setting-item {
        padding: 15px;
    }
}
</style>
@endsection 