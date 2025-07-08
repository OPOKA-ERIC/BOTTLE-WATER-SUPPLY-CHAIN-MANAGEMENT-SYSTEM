@extends('layouts.app', ['activePage' => 'chat', 'title' => 'Chat with Manufacturers'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Chat with Manufacturers</h1>
                        <p class="welcome-subtitle">Communicate about raw materials and orders</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="nc-icon nc-chat-33"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Interface -->
        <div class="row">
            <!-- Manufacturers List -->
            <div class="col-lg-4 col-md-5">
                <div class="manufacturers-list-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="nc-icon nc-settings-gear-65"></i>
                            Manufacturers
                        </h5>
                    </div>
                    <div class="manufacturers-list" id="manufacturersList">
                        @forelse($manufacturersWithChats as $chatData)
                            @php
                                $manufacturer = $chatData['manufacturer'];
                                $unreadCount = $chatData['unreadCount'];
                                $recentMessage = $chatData['recentMessage'];
                                $totalMessages = $chatData['totalMessages'];
                            @endphp
                            <div class="manufacturer-item" onclick="openChat({{ $manufacturer->id }}, '{{ $manufacturer->name }}')">
                                <div class="manufacturer-avatar">
                                    <i class="nc-icon nc-settings-gear-65"></i>
                                </div>
                                <div class="manufacturer-info">
                                    <div class="manufacturer-header">
                                        <span class="manufacturer-name">{{ $manufacturer->name }}</span>
                                        @if($unreadCount > 0)
                                            <span class="unread-badge">{{ $unreadCount }}</span>
                                        @endif
                                    </div>
                                    <span class="manufacturer-email">{{ $manufacturer->email }}</span>
                                    @if($recentMessage)
                                        <span class="last-message">{{ Str::limit($recentMessage->message, 50) }}</span>
                                        <span class="message-time">{{ $recentMessage->created_at->diffForHumans() }}</span>
                                    @else
                                        <span class="no-messages">No messages yet</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="no-manufacturers">
                                <i class="nc-icon nc-settings-gear-65"></i>
                                <p>No manufacturers available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="col-lg-8 col-md-7">
                <div class="chat-area-card">
                    <div class="card-body">
                        <!-- Welcome Message -->
                        <div id="welcomeMessage" class="welcome-chat">
                            <div class="welcome-chat-content">
                                <div class="welcome-chat-icon">
                                    <i class="nc-icon nc-chat-33"></i>
                                </div>
                                <h3 class="welcome-chat-title">Welcome to Chat</h3>
                                <p class="welcome-chat-subtitle">Select a manufacturer from the list to start communicating about raw materials, orders, and other business matters.</p>
                                <div class="welcome-chat-features">
                                    <div class="feature-item">
                                        <i class="nc-icon nc-single-copy-04"></i>
                                        <span>Send text messages</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="nc-icon nc-image"></i>
                                        <span>Share images and files</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="nc-icon nc-time-alarm"></i>
                                        <span>Real-time updates</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Chat (Hidden by default) -->
                        <div id="activeChat" class="active-chat" style="display: none;">
                            <!-- Chat Header -->
                            <div class="chat-header">
                                <div class="chat-user-info">
                                    <div class="chat-user-avatar">
                                        <i class="nc-icon nc-settings-gear-65"></i>
                                    </div>
                                    <div class="chat-user-details">
                                        <h5 class="chat-user-name" id="chatUserName">Manufacturer Name</h5>
                                        <span class="chat-user-status">Online</span>
                                    </div>
                                </div>
                                <div class="chat-actions">
                                    <button class="btn btn-sm btn-outline-secondary" onclick="closeChat()">
                                        <i class="nc-icon nc-minimal-left"></i>
                                        Back
                                    </button>
                                </div>
                            </div>

                            <!-- Messages Container -->
                            <div class="messages-container position-relative" id="messagesContainer">
                                <div id="loadingSpinner" style="display:none;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);z-index:10;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <!-- Messages will be loaded here -->
                            </div>

                            <!-- Message Input -->
                            <div class="message-input-container">
                                <form id="messageForm" class="message-form">
                                    @csrf
                                    <input type="hidden" id="currentManufacturerId" name="manufacturer_id">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="messageInput" name="message" placeholder="Type your message..." required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="nc-icon nc-send"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Welcome Card */
.content {
    padding-top: 100px !important;
}
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

/* Manufacturers List */
.manufacturers-list-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    height: 600px;
    overflow: hidden;
}

.manufacturers-list-card .card-header {
    background: #f8f9fa;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.manufacturers-list-card .card-title {
    margin: 0;
    color: #333;
    font-weight: 600;
}

.manufacturers-list {
    height: calc(100% - 80px);
    overflow-y: auto;
    padding: 0;
}

.manufacturer-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.manufacturer-item:hover {
    background: #f8f9fa;
}

.manufacturer-item.active {
    background: #e3f2fd;
    border-left: 4px solid #2196f3;
}

.manufacturer-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.manufacturer-avatar i {
    color: white;
    font-size: 20px;
}

.manufacturer-info {
    flex: 1;
}

.manufacturer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.manufacturer-name {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
}

.unread-badge {
    background: #ff5722;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

.manufacturer-email {
    color: #666;
    font-size: 0.85rem;
    display: block;
    margin-bottom: 5px;
}

.last-message {
    color: #333;
    font-size: 0.9rem;
    display: block;
    margin-bottom: 2px;
}

.message-time {
    color: #999;
    font-size: 0.8rem;
}

.no-messages {
    color: #999;
    font-style: italic;
    font-size: 0.85rem;
}

.no-manufacturers {
    text-align: center;
    padding: 40px 20px;
    color: #999;
}

.no-manufacturers i {
    font-size: 3rem;
    margin-bottom: 15px;
    display: block;
}

/* Chat Area */
.chat-area-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    height: 600px;
    display: flex;
    flex-direction: column;
}

.chat-area-card .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 0;
}

/* Welcome Chat */
.welcome-chat {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px;
}

.welcome-chat-icon i {
    font-size: 4rem;
    color: #667eea;
    margin-bottom: 20px;
}

.welcome-chat-title {
    color: #333;
    margin-bottom: 15px;
}

.welcome-chat-subtitle {
    color: #666;
    margin-bottom: 30px;
    font-size: 1.1rem;
}

.welcome-chat-features {
    display: flex;
    justify-content: center;
    gap: 30px;
}

.feature-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.feature-item i {
    font-size: 1.5rem;
    color: #667eea;
}

.feature-item span {
    color: #666;
    font-size: 0.9rem;
}

/* Active Chat */
.active-chat {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
}

.chat-user-info {
    display: flex;
    align-items: center;
}

.chat-user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.chat-user-avatar i {
    color: white;
    font-size: 16px;
}

.chat-user-name {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
}

.chat-user-status {
    color: #28a745;
    font-size: 0.85rem;
}

.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f8f9fa;
}

.message {
    display: flex;
    margin-bottom: 15px;
    align-items: flex-start;
}

.message.sent {
    justify-content: flex-end;
}

.message.received {
    justify-content: flex-start;
}

.message-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 10px;
}

.message-avatar i {
    color: white;
    font-size: 14px;
}

.message-content {
    max-width: 70%;
}

.message.sent .message-content {
    order: -1;
}

.message-text {
    background: white;
    padding: 12px 16px;
    border-radius: 18px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 5px;
    word-wrap: break-word;
}

.message.sent .message-text {
    background: #667eea;
    color: #fff;
}

.message.received .message-text {
    background: #f1f1f1;
    color: #222;
    border: 1px solid #e0e0e0;
}

.message-time {
    font-size: 0.75rem;
    color: #999;
    text-align: center;
}

.message-input-container {
    padding: 20px;
    border-top: 1px solid #e9ecef;
    background: white;
}

.message-form {
    display: flex;
    gap: 10px;
}

.message-form .input-group {
    flex: 1;
}

.message-form .form-control {
    border-radius: 25px;
    border: 1px solid #e9ecef;
    padding: 12px 20px;
}

.message-form .btn {
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

@push('js')
<script>
$(document).ready(function() {
    let currentManufacturerId = null;
    let messagePollingInterval = null;

    // Show feedback
    function showFeedback(type, message) {
        const feedback = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>`);
        $('.chat-area-card .card-body').prepend(feedback);
        setTimeout(() => feedback.alert('close'), 3000);
    }

    // Make openChat function globally accessible
    window.openChat = function(manufacturerId, manufacturerName) {
        currentManufacturerId = manufacturerId;
        $('#chatUserName').text(manufacturerName);
        $('#currentManufacturerId').val(manufacturerId);
        $('#welcomeMessage').hide();
        $('#activeChat').show();
        loadMessages(manufacturerId);
        startMessagePolling();
        $('.manufacturer-item').removeClass('active');
        $(`.manufacturer-item[onclick*="${manufacturerId}"]`).addClass('active');
    };

    function closeChat() {
        currentManufacturerId = null;
        stopMessagePolling();
        $('#activeChat').hide();
        $('#welcomeMessage').show();
        $('.manufacturer-item').removeClass('active');
    }

    function loadMessages(manufacturerId) {
        $('#loadingSpinner').show();
        $.ajax({
            url: `/supplier/chats/${manufacturerId}/messages`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#loadingSpinner').hide();
                if (response.success) {
                    displayMessages(response.messages);
                } else {
                    showFeedback('danger', 'Failed to load messages.');
                }
            },
            error: function(xhr) {
                $('#loadingSpinner').hide();
                showFeedback('danger', 'Error loading messages.');
            }
        });
    }

    function displayMessages(messages) {
        const container = $('#messagesContainer');
        container.find('.message').remove();
        messages.forEach(message => {
            const isSent = message.supplier_id == {{ auth()->id() }};
            const messageHtml = `
                <div class="message ${isSent ? 'sent' : 'received'}">
                    <div class="message-avatar">
                        <i class="nc-icon nc-single-02"></i>
                    </div>
                    <div class="message-content">
                        <div class="message-text">${message.message}</div>
                        <div class="message-time">${new Date(message.created_at).toLocaleTimeString()}</div>
                    </div>
                </div>
            `;
            container.append(messageHtml);
        });
        // Auto-scroll to bottom
        container.scrollTop(container[0].scrollHeight);
    }

    // Send message
    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        const message = $('#messageInput').val().trim();
        const manufacturerId = $('#currentManufacturerId').val();
        if (!message || !manufacturerId) return;
        $('#messageForm button[type="submit"]').prop('disabled', true);
        $.ajax({
            url: '/supplier/chats',
            method: 'POST',
            data: {
                manufacturer_id: manufacturerId,
                message: message,
                type: 'text',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#messageForm button[type="submit"]').prop('disabled', false);
                if (response.success) {
                    $('#messageInput').val('');
                    loadMessages(manufacturerId);
                    showFeedback('success', 'Message sent!');
                } else {
                    showFeedback('danger', 'Failed to send message.');
                }
            },
            error: function(xhr) {
                $('#messageForm button[type="submit"]').prop('disabled', false);
                showFeedback('danger', 'Error sending message. Please try again.');
            }
        });
    });

    function startMessagePolling() {
        if (messagePollingInterval) {
            clearInterval(messagePollingInterval);
        }
        messagePollingInterval = setInterval(function() {
            if (currentManufacturerId) {
                loadMessages(currentManufacturerId);
            }
        }, 3000); // Poll every 3 seconds
    }

    function stopMessagePolling() {
        if (messagePollingInterval) {
            clearInterval(messagePollingInterval);
            messagePollingInterval = null;
        }
    }

    window.closeChat = closeChat;
    setInterval(function() { location.reload(); }, 30000);
});
</script>
@endpush
@endsection 