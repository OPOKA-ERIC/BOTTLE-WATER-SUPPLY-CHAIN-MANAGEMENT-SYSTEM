@extends('layouts.app', ['activePage' => 'chat', 'title' => 'Chat with Suppliers'])

@section('content')
<div class="chat-bg-gradient" style="min-height:100vh;">
    <div class="container py-5">
        <!-- Welcome Message -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card p-4 d-flex align-items-center justify-content-between animate__animated animate__fadeInDown" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 18px; color: white; box-shadow: 0 8px 32px rgba(102,126,234,0.18);">
                    <div>
                        <h1 class="mb-2" style="font-weight:700; font-size:2.3rem; letter-spacing:-1px;">Chat with Suppliers</h1>
                        <p class="mb-0" style="opacity:0.92; font-size:1.15rem;">Communicate about raw materials and orders in real time.</p>
                    </div>
                    <div style="font-size:3.2rem; opacity:0.85;"><i class="nc-icon nc-chat-33"></i></div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" style="min-height: 600px;">
            <!-- Supplier List Sidebar -->
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="card h-100 shadow chat-sidebar animate__animated animate__fadeInLeft" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header bg-primary text-white" style="border-radius: 16px 16px 0 0;">
                        <h5 class="mb-0" style="font-weight:600; letter-spacing:0.5px;">Suppliers</h5>
                    </div>
                    <ul class="list-group list-group-flush chat-list" id="suppliersList" style="max-height: 520px; overflow-y: auto;">
                        @forelse($suppliersWithChats as $chatData)
                            @php
                                $supplier = $chatData['supplier'];
                                $unreadCount = $chatData['unreadCount'];
                                $recentMessage = $chatData['recentMessage'] ?? null;
                            @endphp
                            <li class="list-group-item supplier-item chat-list-item" data-supplier-id="{{ $supplier->id }}" style="cursor:pointer; border:0; border-bottom:1px solid #f0f0f0; transition:background 0.2s;" onclick="openChat({{ $supplier->id }}, '{{ $supplier->name }}')">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold" style="font-size:1.08rem;">{{ $supplier->name }}</div>
                                        <div class="text-muted small">{{ $supplier->email }}</div>
                                        @if($recentMessage)
                                            <div class="small text-truncate" style="max-width:180px; color:#888;">{{ Str::limit($recentMessage->message, 30) }}</div>
                                        @endif
                                    </div>
                                    @if($unreadCount > 0)
                                        <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No suppliers found</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <!-- Chat Window -->
            <div class="col-md-8">
                <div class="card h-100 shadow chat-window animate__animated animate__fadeInRight" style="border-radius: 16px; min-height: 600px; overflow: hidden;">
                    <div class="card-header bg-light" style="border-radius: 16px 16px 0 0; border-bottom:1px solid #f0f0f0;">
                        <h5 class="mb-0" id="chatUserName" style="font-weight:600;">Select a supplier to chat</h5>
                    </div>
                    <div class="card-body d-flex flex-column p-0" style="height: 100%; background: #f8f9fa;">
                        <!-- Messages -->
                        <div class="flex-grow-1 overflow-auto mb-3 px-4 pt-4 chat-messages" id="messagesContainer" style="min-height:300px; max-height:420px;">
                            <div class="text-muted text-center" id="noMessages">Select a supplier to start chatting.</div>
                            {{-- Messages will be rendered here by JS using the same structure as show.blade.php --}}
                        </div>
                        <!-- Message Input -->
                        <form id="messageForm" class="d-flex p-3 border-top chat-input-bar" style="gap:10px; display:none; background:#f8f9fa; border-radius:0 0 16px 16px;" autocomplete="off">
                            @csrf
                            <input type="hidden" id="currentSupplierId" name="supplier_id">
                            <input type="text" class="form-control chat-input" id="messageInput" name="message" placeholder="Type your message..." required style="border-radius: 8px;">
                            <button type="submit" class="btn btn-primary shadow-sm" id="sendBtn" style="border-radius: 8px;">
                                <i class="nc-icon nc-send"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.chat-bg-gradient {
    background: linear-gradient(120deg, #f8fafc 0%, #e3e6f3 100%);
    min-height: 100vh;
}
.welcome-card {
    box-shadow: 0 4px 24px rgba(102,126,234,0.15);
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.card.chat-window {
    border-radius: 16px;
    min-height: 600px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    background: #fff;
    box-shadow: 0 8px 32px rgba(102,126,234,0.10);
}
.flex-grow-1.chat-messages {
    background: #f8f9fa;
    padding: 30px 0 0 0;
    overflow-y: auto;
    flex: 1 1 auto;
    min-height: 300px;
    max-height: 420px;
    display: flex;
    flex-direction: column;
    gap: 0;
}
.message-group-label {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 2px;
    margin-left: 60px;
    margin-right: 60px;
    text-align: left;
    font-weight: 600;
}
.message.sent .message-group-label {
    color: #667eea;
    text-align: right;
    margin-left: 0;
    margin-right: 60px;
}
.message.received .message-group-label {
    color: #20c997;
    text-align: left;
    margin-left: 60px;
    margin-right: 0;
}
.message {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    max-width: 70%;
    margin-bottom: 2px;
}
.message.sent {
    align-self: flex-end;
    flex-direction: row-reverse;
    margin-left: 60px !important;
}
.message.sent .message-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #fff !important;
    border-radius: 20px 20px 4px 20px;
    box-shadow: 0 4px 16px rgba(102,126,234,0.10);
    position: relative;
}
.message.sent .message-content::after {
    content: '';
    position: absolute;
    right: -12px;
    top: 18px;
    width: 0;
    height: 0;
    border-top: 12px solid transparent;
    border-bottom: 12px solid transparent;
    border-left: 12px solid #667eea;
    filter: drop-shadow(0 2px 4px rgba(102,126,234,0.10));
}
.message.received {
    align-self: flex-start;
    margin-right: 60px !important;
}
.message.received .message-content {
    background: #f1f1f1 !important;
    color: #222 !important;
    border-radius: 20px 20px 20px 4px;
    border: 1px solid #e0e0e0 !important;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    position: relative;
}
.message.received .message-content::after {
    content: '';
    position: absolute;
    left: -12px;
    top: 18px;
    width: 0;
    height: 0;
    border-top: 12px solid transparent;
    border-bottom: 12px solid transparent;
    border-right: 12px solid #f1f1f1;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.06));
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
.message.sent .message-time { justify-content: flex-end; }
.message-time i { font-size: 12px; }
.card-body.d-flex.flex-column.p-0 { flex: 1 1 auto; display: flex; flex-direction: column; }
.chat-input-bar { background: #fff; border-radius: 0 0 16px 16px; border-top: 1px solid #e0e0e0; position: sticky; bottom: 0; z-index: 2; }
.message-sender-label {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 2px;
    margin-left: 60px;
    margin-right: 60px;
    text-align: left;
    font-weight: 600;
}
.message-sender-label.sent {
    color: #667eea;
    text-align: right;
    margin-left: 0;
    margin-right: 60px;
}
.message-sender-label.received {
    color: #20c997;
    text-align: left;
    margin-left: 60px;
    margin-right: 0;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

@push('js')
<script>
$(document).ready(function() {
    // Ensure CSRF token is sent in AJAX headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let currentSupplierId = null;
    let messagePollingInterval = null;

    // Make openChat globally accessible
    window.openChat = function(supplierId, supplierName) {
        alert('openChat called for supplierId: ' + supplierId);
        console.log('openChat called for supplierId:', supplierId);
        currentSupplierId = supplierId;
        $('#chatUserName').text('Chat with ' + supplierName);
        $('#currentSupplierId').val(supplierId);
        $('#messageInput').prop('disabled', false);
        $('#sendBtn').prop('disabled', false);
        $('#noMessages').hide();
        $('#messageForm').show();
        loadMessages(supplierId);
        startMessagePolling();
        $('.supplier-item').removeClass('active');
        $(`.supplier-item[data-supplier-id='${supplierId}']`).addClass('active');
    }
    console.log('openChat is', window.openChat);

    function loadMessages(supplierId) {
        $.ajax({
            url: `/manufacturer/chats/${supplierId}/messages`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    displayMessages(response.messages);
                }
            },
            error: function(xhr) {
                $('#messagesContainer').html('<div class="text-danger">Error loading messages.</div>');
            }
        });
    }

    // Replace displayMessages to use message grouping and no auto-scroll unless new message
    function displayMessages(messages) {
        const container = $('#messagesContainer');
        container.empty();
        if (!messages.length) {
            container.html('<div class="text-muted text-center">No messages yet.</div>');
            return;
        }
        messages.forEach((message, idx) => {
            // The sender is always the manufacturer field (by your schema)
            let senderName = message.manufacturer && message.manufacturer.name ? message.manufacturer.name : 'Unknown';
            let senderRole = message.manufacturer && message.manufacturer.role ? message.manufacturer.role : 'unknown';
            // Sent if the sender is the current user
            const isSent = message.manufacturer && message.manufacturer.id == {{ auth()->id() }} && message.manufacturer.role == "{{ auth()->user()->role }}";
            const messageHtml = `
                <div class="message ${isSent ? 'sent' : 'received'}">
                    <div class="message-avatar">
                        <i class="nc-icon nc-single-02"></i>
                    </div>
                    <div class="message-content">
                        <div class="message-text">${message.message}</div>
                        <div class="message-time">
                            ${new Date(message.created_at).toLocaleTimeString()}
                            ${isSent ? '<i class=\'nc-icon nc-time-alarm text-muted\'></i>' : ''}
                        </div>
                    </div>
                </div>
            `;
            container.append(messageHtml);
        });
    }

    $('#messageForm').on('submit', function(e) {
        e.preventDefault();
        alert('Message form submitted!');
        console.log('Message form submitted!');
        const message = $('#messageInput').val().trim();
        const supplierId = $('#currentSupplierId').val();
        if (!message || !supplierId) return;
        $.ajax({
            url: '/manufacturer/chats',
            method: 'POST',
            data: {
                supplier_id: supplierId,
                message: message,
                type: 'text',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#messageInput').val('');
                    loadMessages(supplierId);
                }
            },
            error: function(xhr) {
                alert('Error sending message. Please try again.');
                console.log('AJAX error:', xhr);
            }
        });
    });

    function startMessagePolling() {
        if (messagePollingInterval) clearInterval(messagePollingInterval);
        messagePollingInterval = setInterval(function() {
            if (currentSupplierId) loadMessages(currentSupplierId);
        }, 3000);
    }
    function stopMessagePolling() {
        if (messagePollingInterval) {
            clearInterval(messagePollingInterval);
            messagePollingInterval = null;
        }
    }
    $(window).on('beforeunload', function() { stopMessagePolling(); });
});
</script>
@endpush
@endsection 