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
                        <p class="welcome-subtitle">Communicate with manufacturers and administrators, manage conversations, and stay connected</p>
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
                        <h3 class="stats-number">{{ $conversations->count() }}</h3>
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
                        <h3 class="stats-number">{{ $conversations->where('is_read', false)->count() }}</h3>
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
                        <h3 class="stats-number">{{ $conversations->where('is_read', true)->count() }}</h3>
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
                        <h3 class="stats-number">{{ $conversations->where('manufacturer_id', '!=', null)->count() + $conversations->where('admin_id', '!=', null)->count() }}</h3>
                        <p class="stats-label">Active Participants</p>
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
                            <p class="card-subtitle">Manage your conversations with manufacturers and administrators</p>
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
                    @if($conversations->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Recipient</th>
                                        <th>Last Message</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($conversations as $chat)
                                        <tr>
                                            <td>
                                                @if($chat->manufacturer)
                                                    <div class="manufacturer-info">
                                                        <div class="avatar bg-primary">
                                                            <span class="avatar-text">
                                                                {{ substr($chat->manufacturer->name ?? 'N/A', 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div class="manufacturer-details">
                                                            <span class="manufacturer-name">{{ $chat->manufacturer->name ?? 'N/A' }}</span>
                                                            <span class="manufacturer-role">Manufacturer</span>
                                                            <span class="manufacturer-email">{{ $chat->manufacturer->email ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                @elseif($chat->admin)
                                                    <div class="admin-info">
                                                        <div class="avatar bg-warning">
                                                            <span class="avatar-text">
                                                                {{ substr($chat->admin->name ?? 'A', 0, 1) }}
                                                            </span>
                                                        </div>
                                                        <div class="admin-details">
                                                            <span class="admin-name">{{ $chat->admin->name ?? 'Admin' }}</span>
                                                            <span class="admin-role">Administrator</span>
                                                            <span class="admin-email">{{ $chat->admin->email ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                @endif
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
                            {{ $conversations->links() }}
                        </div>
                    @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="nc-icon nc-chat-33"></i>
                                </div>
                                <h5 class="empty-title">No Chat Conversations</h5>
                                <p class="empty-subtitle">You don't have any chat conversations with manufacturers or administrators yet</p>
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
                        <label for="recipient_type">Recipient Type</label>
                        <select class="form-control" id="recipient_type" name="recipient_type" required onchange="toggleRecipientSelect()">
                            <option value="">Choose recipient type...</option>
                            <option value="manufacturer">Manufacturer</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="form-group" id="manufacturer_select" style="display:none;">
                        <label for="manufacturer_id">Select Manufacturer</label>
                        <select class="form-control" id="manufacturer_id" name="recipient_id">
                            <option value="">Choose a manufacturer...</option>
                            @foreach($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }} ({{ $manufacturer->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="admin_select" style="display:none;">
                        <label for="admin_id">Select Administrator</label>
                        <select class="form-control" id="admin_id" name="recipient_id">
                            <option value="">Choose an administrator...</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Initial Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Type your message here..." required maxlength="1000"></textarea>
                        <small class="text-muted">
                            <span id="modalCharCount">0</span>/1000 characters
                        </small>
                    </div>
                    <input type="hidden" name="type" value="text">
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

<script>
function toggleRecipientSelect() {
    var type = document.getElementById('recipient_type').value;
    document.getElementById('manufacturer_select').style.display = (type === 'manufacturer') ? 'block' : 'none';
    document.getElementById('admin_select').style.display = (type === 'admin') ? 'block' : 'none';
    // Clear the other select
    if(type === 'manufacturer') document.getElementById('admin_id').value = '';
    if(type === 'admin') document.getElementById('manufacturer_id').value = '';
}

// Character counter for modal
document.getElementById('message').addEventListener('input', function() {
    const charCount = this.value.length;
    document.getElementById('modalCharCount').textContent = charCount;
});
</script>

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
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 25px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: none;
}

.header-content {
    flex: 1;
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 5px 0;
    color: white;
}

.card-subtitle {
    font-size: 1rem;
    margin: 0;
    opacity: 0.9;
    color: white;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
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

/* Table Styles */
.table {
    margin: 0;
}

.table th {
    border-top: none;
    border-bottom: 2px solid #e9ecef;
    font-weight: 600;
    color: #333;
    padding: 15px 10px;
    background: #f8f9fa;
}

.table td {
    border-top: none;
    border-bottom: 1px solid #e9ecef;
    padding: 20px 10px;
    vertical-align: middle;
}

/* Recipient Info */
.manufacturer-info,
.admin-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.avatar-text {
    font-size: 18px;
    font-weight: 700;
    color: white;
}

.manufacturer-details,
.admin-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.manufacturer-name,
.admin-name {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.manufacturer-role,
.admin-role {
    font-size: 0.8rem;
    color: #666;
    font-weight: 500;
}

.manufacturer-email,
.admin-email {
    font-size: 0.85rem;
    color: #888;
}

/* Message Preview */
.message-preview {
    max-width: 300px;
}

.message-text {
    color: #333;
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-read {
    background: #d4edda;
    color: #155724;
}

.status-unread {
    background: #fff3cd;
    color: #856404;
}

.status-badge i {
    font-size: 12px;
}

/* Date Labels */
.date-label {
    font-size: 0.85rem;
    color: #666;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.action-btn.primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.action-btn i {
    font-size: 14px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 40px;
    color: white;
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

/* Pagination */
.pagination-section {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

/* Modal Styles */
.modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 15px 15px 0 0;
    border-bottom: none;
}

.modal-title {
    color: white;
    font-weight: 600;
}

.modal-title i {
    margin-right: 10px;
}

.modal-body {
    padding: 30px;
}

.modal-footer {
    border-top: 1px solid #e9ecef;
    padding: 20px 30px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-title {
        font-size: 2rem;
    }

    .stats-card {
        padding: 20px;
    }

    .stats-number {
        font-size: 1.5rem;
    }

    .card-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .header-actions {
        justify-content: center;
    }

    .table-responsive {
        font-size: 0.9rem;
    }

    .manufacturer-info,
    .admin-info {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
}
</style>
@endsection
