@extends('layouts.app', ['activePage' => 'chats', 'title' => 'Chat Management'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Chat Management</h1>
                        <p class="welcome-subtitle">Communicate with manufacturers, manage conversations, and stay connected</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chat-33"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-chat-33"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $chats->count() }}</h3>
                        <p class="stats-label">Total Conversations</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>All time</span>
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
                        <h3 class="stats-number">{{ $chats->where('is_read', false)->count() }}</h3>
                        <p class="stats-label">Unread Messages</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Need attention</span>
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
                        <h3 class="stats-number">{{ $chats->where('is_read', true)->count() }}</h3>
                        <p class="stats-label">Read Messages</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>Already viewed</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="nc-icon nc-single-02"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $chats->unique('manufacturer_id')->count() }}</h3>
                        <p class="stats-label">Active Manufacturers</p>
                        <div class="stats-footer">
                            <i class="nc-icon nc-refresh-69"></i>
                            <span>In conversations</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Conversations -->
    <div class="row">
        <div class="col-md-12">
                <div class="content-card">
                <div class="card-header">
                        <div class="header-content">
                    <h4 class="card-title">Chat Conversations</h4>
                            <p class="card-subtitle">Manage your conversations with manufacturers and track message status</p>
                        </div>
                        <div class="header-actions">
                            <button class="action-btn primary" data-toggle="modal" data-target="#newChatModal">
                                <i class="nc-icon nc-simple-add"></i>
                                <span>New Chat</span>
                            </button>
                            <div class="header-icon">
                                <i class="nc-icon nc-chat-33"></i>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    @if($chats->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Manufacturer</th>
                                        <th>Last Message</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chats as $chat)
                                        <tr>
                                            <td>
                                                    <div class="manufacturer-info">
                                                        <div class="avatar">
                                                            <span class="avatar-text">
                                                            {{ substr($chat->manufacturer->name ?? 'N/A', 0, 1) }}
                                                        </span>
                                                    </div>
                                                        <div class="manufacturer-details">
                                                            <span class="manufacturer-name">{{ $chat->manufacturer->name ?? 'N/A' }}</span>
                                                            <span class="manufacturer-email">{{ $chat->manufacturer->email ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                    <div class="message-preview">
                                                        <span class="message-text">{{ Str::limit($chat->message, 50) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                    <span class="status-badge status-{{ $chat->is_read ? 'read' : 'unread' }}">
                                                        <i class="nc-icon {{ $chat->is_read ? 'nc-check-2' : 'nc-time-alarm' }}"></i>
                                                        {{ $chat->is_read ? 'Read' : 'Unread' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="date-label">{{ $chat->updated_at->format('M d, Y H:i') }}</span>
                                            </td>
                                            <td>
                                                    <a href="{{ route('supplier.chats.show', $chat->id) }}" class="action-btn primary">
                                                        <i class="nc-icon nc-zoom-split-in"></i>
                                                        <span>View</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                            <div class="pagination-section">
                            {{ $chats->links() }}
                        </div>
                    @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-chat-33"></i>
                                </div>
                                <h5 class="empty-title">No Chat Conversations</h5>
                                <p class="empty-subtitle">You don't have any chat conversations with manufacturers yet</p>
                                <div class="empty-actions">
                                    <button class="action-btn primary" data-toggle="modal" data-target="#newChatModal">
                                        <i class="nc-icon nc-simple-add"></i>
                                        <span>Start New Conversation</span>
                            </button>
                                </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Chat Modal -->
<div class="modal fade" id="newChatModal" tabindex="-1" role="dialog" aria-labelledby="newChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newChatModalLabel">
                    <i class="nc-icon nc-chat-33"></i>
                    Start New Conversation
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('supplier.chats.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="manufacturer_id">Select Manufacturer</label>
                        <select class="form-control" id="manufacturer_id" name="manufacturer_id" required>
                            <option value="">Choose a manufacturer...</option>
                            <!-- Add your manufacturers here -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Initial Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Type your message here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="nc-icon nc-send"></i>
                        Send Message
                    </button>
                </div>
            </form>
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

/* Statistics Cards */
.stats-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 30px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stats-icon i {
    font-size: 28px;
    color: white;
}

.stats-content {
    flex: 1;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 5px 0;
    line-height: 1.2;
}

.stats-label {
    font-size: 1rem;
    color: #666;
    margin: 0 0 10px 0;
    font-weight: 500;
}

.stats-footer {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #888;
}

.stats-footer i {
    font-size: 14px;
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

.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-icon i {
    font-size: 24px;
    color: white;
}

.card-body {
    padding: 30px;
}

/* Table Styling */
.table {
    margin: 0;
}

.table thead th {
    background: rgba(25, 118, 210, 0.1);
    color: #333;
    font-weight: 600;
    border: none;
    padding: 15px;
    font-size: 0.9rem;
}

.table tbody td {
    padding: 15px;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    vertical-align: middle;
}

.table tbody tr:hover {
    background: rgba(25, 118, 210, 0.05);
}

/* Manufacturer Info */
.manufacturer-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.avatar-text {
    color: white;
    font-weight: 700;
    font-size: 1.2rem;
    text-transform: uppercase;
}

.manufacturer-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.manufacturer-name {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.manufacturer-email {
    color: #666;
    font-size: 0.85rem;
}

/* Message Preview */
.message-preview {
    max-width: 300px;
}

.message-text {
    color: #666;
    font-style: italic;
    font-size: 0.9rem;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-read {
    background: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
}

.status-unread {
    background: rgba(237, 108, 2, 0.1);
    color: #ed6c02;
}

.status-badge i {
    font-size: 12px;
}

.date-label {
    font-weight: 500;
    color: #666;
    font-size: 0.9rem;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.action-btn i {
    font-size: 14px;
}

/* Pagination Section */
.pagination-section {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    gap: 5px;
}

.page-link {
    padding: 8px 12px;
    border: 1px solid rgba(25, 118, 210, 0.2);
    background: rgba(255, 255, 255, 0.8);
    color: #1976d2;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: rgba(25, 118, 210, 0.1);
    border-color: #1976d2;
    color: #1976d2;
    transform: translateY(-2px);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: rgba(25, 118, 210, 0.1);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 40px;
    color: #1976d2;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 10px 0;
}

.empty-subtitle {
    font-size: 1rem;
    color: #666;
    margin: 0 0 30px 0;
}

.empty-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
}

/* Modal Styling */
.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.modal-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    color: white;
    border-radius: 20px 20px 0 0;
    border: none;
    padding: 20px 30px;
}

.modal-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.modal-title i {
    font-size: 20px;
}

.modal-body {
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    border-radius: 10px;
    border: 1px solid rgba(0, 0, 0, 0.1);
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #1976d2;
    box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
}

.modal-footer {
    border: none;
    padding: 20px 30px;
    background: rgba(0, 0, 0, 0.02);
}

.btn {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
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
    
    .stats-card {
        padding: 20px;
    }
    
    .stats-number {
        font-size: 1.5rem;
    }
    
    .card-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .header-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .header-icon {
        margin: 0;
    }
    
    .manufacturer-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .message-preview {
        max-width: 200px;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endsection 