@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">
                                <i class="nc-icon nc-chat-33"></i>
                                Chat with
                                @if($chat->manufacturer)
                                    {{ $chat->manufacturer->name }}
                                    <span class="badge badge-info">Manufacturer</span>
                                @elseif($chat->admin)
                                    {{ $chat->admin->name }}
                                    <span class="badge badge-warning">Administrator</span>
                                @else
                                    Unknown
                                @endif
                            </h4>
                            <p class="card-category">Conversation details</p>
                        </div>
                        <a href="{{ route('supplier.chats.index') }}" class="btn btn-secondary">
                            <i class="nc-icon nc-minimal-left"></i> Back to Chats
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chat Header -->
                    <div class="chat-header mb-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-lg rounded-circle d-flex align-items-center justify-content-center me-3
                                {{ $chat->manufacturer ? 'bg-primary' : 'bg-warning' }}">
                                <span class="text-white font-weight-bold" style="font-size: 24px;">
                                    @if($chat->manufacturer)
                                        {{ substr($chat->manufacturer->name ?? 'M', 0, 1) }}
                                    @elseif($chat->admin)
                                        {{ substr($chat->admin->name ?? 'A', 0, 1) }}
                                    @else
                                        ?
                                    @endif
                                </span>
                            </div>
                            <div>
                                <h5 class="mb-0">
                                    @if($chat->manufacturer)
                                        {{ $chat->manufacturer->name }}
                                    @elseif($chat->admin)
                                        {{ $chat->admin->name }}
                                    @else
                                        Unknown
                                    @endif
                                </h5>
                                <p class="text-muted mb-0">
                                    @if($chat->manufacturer)
                                        {{ $chat->manufacturer->email ?? 'N/A' }}
                                    @elseif($chat->admin)
                                        {{ $chat->admin->email ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                                <small class="text-muted">
                                    @if($chat->is_read)
                                        <span class="badge badge-success">Read</span>
                                    @else
                                        <span class="badge badge-warning">Unread</span>
                                    @endif
                                    • Last updated: {{ $chat->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div class="chat-messages mb-4" id="chatMessages">
                        @foreach($conversationMessages as $message)
                            <div class="message-container">
                                <div class="message {{ $message->supplier_id === auth()->id() ? 'supplier-message' : 'recipient-message' }}">
                                    <div class="message-content">
                                        <div class="message-text">
                                            {{ $message->message }}
                                        </div>
                                        <div class="message-time">
                                            {{ $message->created_at->format('M d, Y H:i') }}
                                            @if($message->supplier_id === auth()->id())
                                                <i class="nc-icon nc-check-2 ml-1"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Reply Form -->
                    <div class="chat-reply">
                        <form id="replyForm" action="{{ route('supplier.chats.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="recipient_type" value="{{ $chat->manufacturer ? 'manufacturer' : 'admin' }}">
                            <input type="hidden" name="recipient_id" value="{{ $chat->manufacturer_id ?? $chat->admin_id }}">
                            <div class="form-group">
                                <label for="reply_message">Reply to
                                    @if($chat->manufacturer)
                                        {{ $chat->manufacturer->name }}
                                    @elseif($chat->admin)
                                        {{ $chat->admin->name }}
                                    @else
                                        Unknown
                                    @endif
                                </label>
                                <div class="input-group">
                                    <textarea class="form-control" id="reply_message" name="message" rows="3"
                                        placeholder="Type your reply here..." required maxlength="1000"></textarea>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="nc-icon nc-send"></i> Send
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    <span id="charCount">0</span>/1000 characters
                                </small>
                            </div>
                            <input type="hidden" name="type" value="text">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.avatar-lg {
    width: 60px;
    height: 60px;
}

.chat-messages {
    max-height: 500px;
    overflow-y: auto;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    background-color: #f8f9fa;
}

.message-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 15px;
}

.message {
    display: flex;
    margin-bottom: 10px;
}

.supplier-message {
    justify-content: flex-end;
}

.recipient-message {
    justify-content: flex-start;
}

.message-content {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
    word-wrap: break-word;
}

.supplier-message .message-content {
    background-color: #007bff;
    color: white;
    border-bottom-right-radius: 4px;
}

.recipient-message .message-content {
    background-color: #e9ecef;
    color: #333;
    border-bottom-left-radius: 4px;
}

.message-text {
    margin-bottom: 5px;
    line-height: 1.4;
}

.message-time {
    font-size: 12px;
    opacity: 0.7;
    display: flex;
    align-items: center;
    gap: 5px;
}

.chat-reply {
    border-top: 1px solid #e9ecef;
    padding-top: 20px;
}

.input-group {
    border-radius: 8px;
    overflow: hidden;
}

.input-group textarea {
    border: 1px solid #ced4da;
    border-right: none;
    resize: none;
}

.input-group-append .btn {
    border-radius: 0;
    border-left: none;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

/* Scrollbar styling */
.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endpush

@push('js')
<script>
// Character counter
document.getElementById('reply_message').addEventListener('input', function() {
    const charCount = this.value.length;
    document.getElementById('charCount').textContent = charCount;
});

// Auto-scroll to bottom of chat
function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Scroll to bottom on page load
document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
});

// Form submission with AJAX for better UX
document.getElementById('replyForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const messageInput = document.getElementById('reply_message');
    const message = messageInput.value.trim();

    if (!message) return;

    // Disable form during submission
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="nc-icon nc-refresh-69"></i> Sending...';
    submitBtn.disabled = true;

    fetch('{{ route("supplier.chats.send") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            recipient_type: formData.get('recipient_type'),
            recipient_id: formData.get('recipient_id'),
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add message to chat
            const chatMessages = document.getElementById('chatMessages');
            const messageContainer = document.createElement('div');
            messageContainer.className = 'message-container';
            messageContainer.innerHTML = `
                <div class="message supplier-message">
                    <div class="message-content">
                        <div class="message-text">${message}</div>
                        <div class="message-time">
                            ${new Date().toLocaleString()}
                            <i class="nc-icon nc-check-2 ml-1"></i>
                        </div>
                    </div>
                </div>
            `;
            chatMessages.appendChild(messageContainer);

            // Clear input and reset form
            messageInput.value = '';
            document.getElementById('charCount').textContent = '0';

            // Scroll to bottom
            scrollToBottom();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to send message. Please try again.');
    })
    .finally(() => {
        // Re-enable form
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function markAsRead() {
    fetch('{{ route("supplier.chats.read", $chat->id) }}', {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI to show as read
            const statusBadge = document.querySelector('.badge-warning');
            if (statusBadge) {
                statusBadge.className = 'badge badge-success';
                statusBadge.textContent = 'Read';
            }
        }
    })
    .catch(error => {
        console.error('Error marking as read:', error);
    });
}
</script>
@endpush
