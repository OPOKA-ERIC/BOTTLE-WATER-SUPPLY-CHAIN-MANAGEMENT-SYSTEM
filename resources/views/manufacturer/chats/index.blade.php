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
}
.welcome-card {
    box-shadow: 0 4px 24px rgba(102,126,234,0.15);
    font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
}
.supplier-item.active, .supplier-item:active {
    background: linear-gradient(90deg, #a1c4fd 0%, #c2e9fb 100%) !important;
    color: #234567 !important;
    transition: background 0.2s, color 0.2s;
}
.supplier-item:hover {
    background: linear-gradient(90deg, #e0eafc 0%, #cfdef3 100%) !important;
    color: #234567 !important;
    transition: background 0.2s, color 0.2s;
}
.chat-sidebar {
    background: #fff;
}
.chat-window {
    background: #fff;
}
.chat-messages {
    scrollbar-width: thin;
    scrollbar-color: #b3b3b3 #f8f9fa;
}
.chat-messages::-webkit-scrollbar {
    width: 8px;
    background: #f8f9fa;
}
.chat-messages::-webkit-scrollbar-thumb {
    background: #b3b3b3;
    border-radius: 4px;
}
.chat-input-bar {
    border-top: 1px solid #e0e0e0;
}
.chat-input:focus {
    box-shadow: 0 0 0 2px #667eea33;
    border-color: #667eea;
}
.message.sent .chat-bubble, .message.sent .message-text {
    background: #667eea !important;
    color: #fff !important;
}
.message.received .chat-bubble, .message.received .message-text {
    background: #f1f1f1 !important;
    color: #222 !important;
    border: 1px solid #e0e0e0 !important;
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

    function displayMessages(messages) {
        const container = $('#messagesContainer');
        container.empty();
        if (!messages.length) {
            container.html('<div class="text-muted text-center">No messages yet.</div>');
            return;
        }
        messages.forEach(message => {
            const isSent = message.manufacturer_id == {{ auth()->id() }};
            const messageHtml = `
                <div class="d-flex mb-2 ${isSent ? 'justify-content-end' : 'justify-content-start'}">
                    <div class="chat-bubble p-2 px-3 rounded message ${isSent ? 'sent' : 'received'}" style="max-width:70%; box-shadow:0 2px 8px rgba(102,126,234,0.07); border-radius:18px;">
                        <div style="word-break:break-word;">${message.message}</div>
                        <div class="small text-muted text-end" style="font-size:0.85em;">${new Date(message.created_at).toLocaleTimeString()}</div>
                    </div>
                </div>
            `;
            container.append(messageHtml);
        });
        container.scrollTop(container[0].scrollHeight);
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