@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Chat with {{ $chat->manufacturer->name ?? 'Manufacturer' }}</h4>
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
                            <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                <span class="text-white font-weight-bold" style="font-size: 24px;">
                                    {{ substr($chat->manufacturer->name ?? 'M', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $chat->manufacturer->name ?? 'Manufacturer' }}</h5>
                                <p class="text-muted mb-0">{{ $chat->manufacturer->email ?? 'N/A' }}</p>
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
                    <div class="chat-messages mb-4 chat-debug-style">
                        <div class="message-container">
                            @foreach($messages as $message)
                                <div class="message {{ $message->supplier_id == auth()->id() ? 'sent' : 'received' }}">
                                    <div class="message-content">
                                        <div class="message-text">
                                            {{ $message->message }}
                                        </div>
                                        <div class="message-time">
                                            {{ $message->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reply Form -->
                    <div class="chat-reply">
                        <form action="{{ route('supplier.chats.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="manufacturer_id" value="{{ $chat->manufacturer_id }}">
                            <div class="form-group">
                                <label for="reply_message">Reply to {{ $chat->manufacturer->name ?? 'Manufacturer' }}</label>
                                <textarea class="form-control" id="reply_message" name="message" rows="4" placeholder="Type your reply here..." required></textarea>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="nc-icon nc-send"></i> Send Reply
                                </button>
                                <button type="button" class="btn btn-outline-secondary ml-2" onclick="markAsRead()">
                                    <i class="nc-icon nc-check-2"></i> Mark as Read
                                </button>
                            </div>
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
    max-height: 400px;
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
}

.message {
    display: flex;
    margin-bottom: 10px;
}

.message.sent {
    justify-content: flex-end;
}

.message.received {
    justify-content: flex-start;
}

.message-content {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
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

.message-text {
    margin-bottom: 5px;
    word-wrap: break-word;
}

.message-time {
    font-size: 12px;
    opacity: 0.7;
}

.chat-reply {
    border-top: 1px solid #e9ecef;
    padding-top: 20px;
}

/* Debug timestamp: {{ now() }} */
.chat-debug-style .message.sent .message-content {
    background: #667eea !important;
    color: #fff !important;
    border: 2px solid #003399 !important;
}
.chat-debug-style .message.received .message-content {
    background: #f1f1f1 !important;
    color: #222 !important;
    border: 2px solid #ff0000 !important;
}
</style>
@endpush

@push('js')
<script>
function markAsRead() {
    fetch('{{ route("supplier.chats.read", $chat->id) }}', {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the UI to show as read
            const badge = document.querySelector('.badge');
            if (badge) {
                badge.className = 'badge badge-success';
                badge.textContent = 'Read';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endpush 