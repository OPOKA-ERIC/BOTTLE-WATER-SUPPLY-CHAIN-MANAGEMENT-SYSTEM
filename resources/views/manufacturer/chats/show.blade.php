@extends('layouts.app', ['activePage' => 'chat', 'title' => 'Chat with ' . $supplier->name])

@section('content')
<div class="content">
    <div class="container-fluid">
        <!-- Chat Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="chat-header-card">
                    <div class="chat-header-content">
                        <div class="supplier-info">
                            <div class="supplier-avatar">
                                <i class="nc-icon nc-single-02"></i>
                            </div>
                            <div class="supplier-details">
                                <h1 class="supplier-name">{{ $supplier->name }}</h1>
                                <p class="supplier-email">{{ $supplier->email }}</p>
                                <span class="chat-status">Online</span>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <a href="{{ route('manufacturer.chats.index') }}" class="btn btn-outline-secondary">
                                <i class="nc-icon nc-minimal-left"></i>
                                Back to Chats
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Interface -->
        <div class="row">
            <div class="col-12">
                <div class="chat-container">
                    <!-- Messages Area -->
                    <div class="messages-area chat-debug-style" id="messagesArea">
                        <div class="messages-container" id="messagesContainer">
                            @foreach($messages as $message)
                                <div class="message {{ $message->manufacturer_id == auth()->id() ? 'sent' : 'received' }}">
                                    <div class="message-avatar">
                                        <i class="nc-icon nc-single-02"></i>
                                    </div>
                                    <div class="message-content">
                                        @if($message->type === 'file' && $message->file_path)
                                            <div class="file-message">
                                                <i class="nc-icon nc-single-copy-04"></i>
                                                <a href="{{ Storage::url($message->file_path) }}" target="_blank" class="file-link">
                                                    {{ basename($message->file_path) }}
                                                </a>
                                            </div>
                                        @endif
                                        <div class="message-text">{{ $message->message }}</div>
                                        <div class="message-time">
                                            {{ $message->created_at->format('M d, Y g:i A') }}
                                            @if($message->manufacturer_id == auth()->id())
                                                <i class="nc-icon {{ $message->is_read ? 'nc-check-2 text-success' : 'nc-time-alarm text-muted' }}"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="message-input-area">
                        <form id="messageForm" enctype="multipart/form-data">
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="openFileInput()" title="Attach File">
                                    <i class="nc-icon nc-single-copy-04"></i>
                                </button>
                                <input type="text" class="form-control" id="messageInput" placeholder="Type your message about raw materials..." maxlength="1000">
                                <button type="submit" class="btn btn-primary">
                                    <i class="nc-icon nc-send"></i>
                                </button>
                            </div>
                            <input type="file" id="fileInput" style="display: none;" accept="image/*,.pdf,.doc,.docx">
                            <input type="hidden" id="supplierId" value="{{ $supplier->id }}">
                            <input type="hidden" id="messageType" value="text">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Chat Header */
.chat-header-card {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%);
    border-radius: 20px;
    padding: 30px;
    color: white;
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.chat-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.supplier-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.supplier-avatar {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.supplier-avatar i {
    font-size: 28px;
    color: white;
}

.supplier-details {
    flex: 1;
}

.supplier-name {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 5px 0;
    line-height: 1.2;
}

.supplier-email {
    font-size: 1rem;
    margin: 0 0 8px 0;
    opacity: 0.9;
}

.chat-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    opacity: 0.8;
}

.chat-status::before {
    content: '';
    width: 8px;
    height: 8px;
    background: #4caf50;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.chat-actions .btn {
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Chat Container */
.chat-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    height: 600px;
    display: flex;
    flex-direction: column;
}

/* Messages Area */
.messages-area {
    flex: 1;
    overflow-y: auto;
    padding: 30px;
    background: #f8f9fa;
}

.messages-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.message {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    max-width: 70%;
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.sent {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message.received {
    align-self: flex-start;
}

.message-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.message.sent .message-avatar {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.message.received .message-avatar {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.message-avatar i {
    font-size: 18px;
    color: white;
}

.message-content {
    background: white;
    padding: 15px 20px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    position: relative;
    min-width: 200px;
}

.message.sent .message-content {
    background: #667eea !important;
    color: #fff !important;
}

.message.received .message-content {
    background: #f1f1f1 !important;
    color: #222 !important;
    border: 1px solid #e0e0e0 !important;
}

.file-message {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    padding: 10px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.file-message i {
    font-size: 20px;
}

.file-link {
    color: inherit;
    text-decoration: none;
    font-weight: 500;
}

.file-link:hover {
    text-decoration: underline;
}

.message-text {
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 8px;
    word-wrap: break-word;
}

.message-time {
    font-size: 0.8rem;
    opacity: 0.7;
    display: flex;
    align-items: center;
    gap: 5px;
}

.message.sent .message-time {
    justify-content: flex-end;
}

.message-time i {
    font-size: 12px;
}

/* Message Input Area */
.message-input-area {
    padding: 25px;
    background: white;
    border-top: 1px solid #e9ecef;
}

.input-group {
    display: flex;
    align-items: center;
    gap: 15px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 25px;
    padding: 15px 25px;
    font-size: 1rem;
    transition: all 0.3s ease;
    flex: 1;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.3s ease;
    font-size: 18px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    background: white;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chat-header-content {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .supplier-info {
        flex-direction: column;
        gap: 15px;
    }
    
    .chat-container {
        height: 500px;
    }
    
    .messages-area {
        padding: 20px;
    }
    
    .message {
        max-width: 85%;
    }
    
    .message-input-area {
        padding: 20px;
    }
    
    .input-group {
        gap: 10px;
    }
    
    .btn {
        width: 45px;
        height: 45px;
        font-size: 16px;
    }
}

/* Scrollbar Styling */
.messages-area::-webkit-scrollbar {
    width: 6px;
}

.messages-area::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.messages-area::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.messages-area::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Debug timestamp: {{ now() }} */
.messages-area.chat-debug-style .message.sent .message-content {
    background: #667eea !important;
    color: #fff !important;
    border: 2px solid #003399 !important;
}
.messages-area.chat-debug-style .message.received .message-content {
    background: #f1f1f1 !important;
    color: #222 !important;
    border: 2px solid #ff0000 !important;
}
</style>

@push('js')
<script>
let messagePollingInterval = null;

// Send message
$('#messageForm').on('submit', function(e) {
    e.preventDefault();
    
    const message = $('#messageInput').val().trim();
    const supplierId = $('#supplierId').val();
    const type = $('#messageType').val();
    
    if (!message || !supplierId) return;
    
    const formData = new FormData();
    formData.append('supplier_id', supplierId);
    formData.append('message', message);
    formData.append('type', type);
    
    // Add file if selected
    const fileInput = $('#fileInput')[0];
    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }
    
    fetch('/manufacturer/chats', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#messageInput').val('');
            $('#fileInput').val('');
            $('#messageType').val('text');
            
            // Add new message to chat
            addMessageToChat(data.message);
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Failed to send message. Please try again.');
    });
});

// Add message to chat
function addMessageToChat(message) {
    const isSent = message.manufacturer_id == {{ auth()->id() }};
    const messageHtml = `
        <div class="message ${isSent ? 'sent' : 'received'}">
            <div class="message-avatar">
                <i class="nc-icon nc-single-02"></i>
            </div>
            <div class="message-content">
                ${message.type === 'file' && message.file_path ? `
                    <div class="file-message">
                        <i class="nc-icon nc-single-copy-04"></i>
                        <a href="/storage/${message.file_path}" target="_blank" class="file-link">
                            ${message.file_path.split('/').pop()}
                        </a>
                    </div>
                ` : ''}
                <div class="message-text">${message.message}</div>
                <div class="message-time">
                    ${new Date(message.created_at).toLocaleString()}
                    ${isSent ? '<i class="nc-icon nc-time-alarm text-muted"></i>' : ''}
                </div>
            </div>
        </div>
    `;
    
    $('#messagesContainer').append(messageHtml);
    scrollToBottom();
}

// Open file input
function openFileInput() {
    $('#fileInput').click();
}

// Handle file selection
$('#fileInput').on('change', function() {
    const file = this.files[0];
    if (file) {
        $('#messageType').val('file');
        $('#messageInput').val(`File: ${file.name}`);
    }
});

// Scroll to bottom of messages
function scrollToBottom() {
    const messagesArea = document.getElementById('messagesArea');
    messagesArea.scrollTop = messagesArea.scrollHeight;
}

// Start polling for new messages
function startMessagePolling() {
    messagePollingInterval = setInterval(() => {
        loadNewMessages();
    }, 3000); // Poll every 3 seconds
}

// Load new messages
function loadNewMessages() {
    const supplierId = $('#supplierId').val();
    const lastMessageTime = $('.message').last().find('.message-time').text();
    
    fetch(`/manufacturer/chats/${supplierId}/messages`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const currentMessages = $('.message').length;
                const newMessages = data.messages.slice(currentMessages);
                
                newMessages.forEach(message => {
                    addMessageToChat(message);
                });
            }
        })
        .catch(error => {
            console.error('Error loading new messages:', error);
        });
}

// Stop polling
function stopMessagePolling() {
    if (messagePollingInterval) {
        clearInterval(messagePollingInterval);
        messagePollingInterval = null;
    }
}

// Initialize chat
$(document).ready(function() {
    // Scroll to bottom on page load
    scrollToBottom();
    
    // Start polling for new messages
    startMessagePolling();
    
    // Stop polling when leaving page
    $(window).on('beforeunload', function() {
        stopMessagePolling();
    });
    
    // Auto-resize textarea (if using textarea instead of input)
    $('#messageInput').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endpush
@endsection 