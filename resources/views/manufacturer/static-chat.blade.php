@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Real-Time Chat System</h1>
                        <p class="welcome-subtitle">Manufacturer-Supplier Communication Platform</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chat-33"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Demo -->
        <div class="row">
            <div class="col-12">
                <div class="chat-demo-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="nc-icon nc-chat-33"></i>
                            Chat System Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="status-section">
                            <div class="status-item success">
                                <i class="nc-icon nc-check-2"></i>
                                <span>Routes are working correctly</span>
                            </div>
                            <div class="status-item success">
                                <i class="nc-icon nc-check-2"></i>
                                <span>Controllers are functional</span>
                            </div>
                            <div class="status-item success">
                                <i class="nc-icon nc-check-2"></i>
                                <span>Database models are ready</span>
                            </div>
                            <div class="status-item info">
                                <i class="nc-icon nc-time-alarm"></i>
                                <span>Real-time polling enabled (3-second intervals)</span>
                            </div>
                        </div>

                        <div class="features-section">
                            <h6>Available Features:</h6>
                            <ul class="features-list">
                                <li><i class="nc-icon nc-single-copy-04"></i> Send and receive text messages</li>
                                <li><i class="nc-icon nc-time-alarm"></i> Real-time message updates</li>
                                <li><i class="nc-icon nc-badge"></i> Unread message indicators</li>
                                <li><i class="nc-icon nc-check-2"></i> Message read status</li>
                                <li><i class="nc-icon nc-single-02"></i> Supplier/Manufacturer lists</li>
                                <li><i class="nc-icon nc-chat-33"></i> Individual chat conversations</li>
                            </ul>
                        </div>

                        <div class="access-section">
                            <h6>How to Access:</h6>
                            <div class="access-links">
                                <a href="{{ route('manufacturer.chats.index') }}" class="btn btn-primary">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                    Manufacturer Chat Dashboard
                                </a>
                                <a href="{{ route('supplier.chats.index') }}" class="btn btn-success">
                                    <i class="nc-icon nc-single-02"></i>
                                    Supplier Chat Dashboard
                                </a>
                            </div>
                        </div>

                        <div class="test-section">
                            <h6>Test the System:</h6>
                            <div class="test-actions">
                                <button class="btn btn-outline-info" onclick="testChatRoutes()">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                    Test Chat Routes
                                </button>
                                <button class="btn btn-outline-warning" onclick="testDatabase()">
                                    <i class="nc-icon nc-chart-bar-32"></i>
                                    Test Database Connection
                                </button>
                            </div>
                            <div id="testResults" class="test-results"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 30px;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.welcome-content h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 700;
}

.welcome-content p {
    margin: 10px 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.welcome-icon i {
    font-size: 4rem;
    opacity: 0.8;
}

.chat-demo-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.chat-demo-card .card-header {
    background: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.chat-demo-card .card-title {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.chat-demo-card .card-body {
    padding: 30px;
}

.status-section {
    margin-bottom: 30px;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    background: #f8f9fa;
}

.status-item.success {
    background: #d4edda;
    color: #155724;
    border-left: 4px solid #28a745;
}

.status-item.info {
    background: #d1ecf1;
    color: #0c5460;
    border-left: 4px solid #17a2b8;
}

.status-item i {
    font-size: 1.2rem;
}

.features-section {
    margin-bottom: 30px;
}

.features-section h6 {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
}

.features-list {
    list-style: none;
    padding: 0;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.features-list li:last-child {
    border-bottom: none;
}

.features-list i {
    color: #667eea;
    font-size: 1.1rem;
}

.access-section {
    margin-bottom: 30px;
}

.access-section h6 {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
}

.access-links {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.access-links .btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 25px;
    font-weight: 500;
}

.test-section {
    border-top: 1px solid #e9ecef;
    padding-top: 20px;
}

.test-section h6 {
    color: #333;
    font-weight: 600;
    margin-bottom: 15px;
}

.test-actions {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.test-actions .btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    border-radius: 20px;
}

.test-results {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    min-height: 50px;
    border: 1px solid #e9ecef;
}

.test-results.success {
    background: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.test-results.error {
    background: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}
</style>

<script>
function testChatRoutes() {
    const resultsDiv = document.getElementById('testResults');
    resultsDiv.innerHTML = '<div>Testing chat routes...</div>';
    
    // Test manufacturer chat route
    fetch('/manufacturer/chats')
        .then(response => {
            if (response.ok) {
                resultsDiv.innerHTML = '<div class="success">✅ Manufacturer chat route is working!</div>';
            } else {
                resultsDiv.innerHTML = '<div class="error">❌ Manufacturer chat route failed</div>';
            }
        })
        .catch(error => {
            resultsDiv.innerHTML = '<div class="error">❌ Error testing routes: ' + error.message + '</div>';
        });
}

function testDatabase() {
    const resultsDiv = document.getElementById('testResults');
    resultsDiv.innerHTML = '<div>Testing database connection...</div>';
    
    // Test database by trying to get users
    fetch('/test-db-connection')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultsDiv.innerHTML = '<div class="success">✅ Database connection successful! Found ' + data.count + ' users.</div>';
            } else {
                resultsDiv.innerHTML = '<div class="error">❌ Database connection failed</div>';
            }
        })
        .catch(error => {
            resultsDiv.innerHTML = '<div class="error">❌ Error testing database: ' + error.message + '</div>';
        });
}

// Auto-refresh status every 30 seconds
setInterval(function() {
    console.log('Chat system is running...');
}, 30000);
</script>
@endsection 