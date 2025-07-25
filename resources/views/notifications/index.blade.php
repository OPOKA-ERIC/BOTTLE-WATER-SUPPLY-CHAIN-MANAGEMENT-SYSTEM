@extends('layouts.app')

@section('content')
<div class="container notifications-page-container" style="margin-top: 100px; min-height: 80vh; background: #f8f9fa; border-radius: 18px; box-shadow: 0 2px 12px rgba(44,62,80,0.04); padding-top: 40px;">
    <div class="notifications-header d-flex align-items-center mb-4 justify-content-between" style="background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%); color: white; padding: 25px 30px; border-radius: 16px; box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08);">
        <div class="d-flex align-items-center">
            <h2 class="mb-0" style="color: white;"><i class="nc-icon nc-bell-55 mr-2"></i> Notifications</h2>
            <span class="badge badge-pill badge-primary ml-3" style="font-size:1.1rem; background: #1976d2; color: white;">{{ count($notifications) }}</span>
        </div>
        <button id="refreshNotifications" class="btn btn-light btn-refresh ml-auto" title="Refresh Notifications"><i class="nc-icon nc-refresh-69"></i> Refresh</button>
    </div>
    <div class="row" id="notificationsList">
        @forelse($notifications as $notification)
            <div class="col-md-6 col-lg-4 mb-4 notification-card-col" data-id="{{ $notification['id'] ?? '' }}">
                <div class="card shadow-sm notification-card notification-{{ $notification['type'] }} animate__animated animate__fadeInUp">
                    <div class="card-body d-flex align-items-start">
                        <div class="notification-icon mr-3">
                            <i class="{{ $notification['icon'] }}"></i>
                        </div>
                        <div class="notification-content flex-grow-1">
                            <h5 class="card-title mb-1">{{ $notification['title'] }}</h5>
                            <p class="card-text mb-2">{{ $notification['text'] }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">{{ $notification['time'] }}</small>
                                @if(!empty($notification['link']) && $notification['link'] !== '#')
                                    <a href="{{ $notification['link'] }}" class="btn btn-sm btn-outline-primary ml-2" target="_blank">View</a>
                                @endif
                            </div>
                            <div class="notification-actions d-flex gap-2">
                                @if(isset($notification['is_read']) && !$notification['is_read'])
                                    <button class="btn btn-sm btn-success mark-read-btn" data-id="{{ $notification['id'] ?? '' }}"><i class="nc-icon nc-check-2"></i> Mark as Read</button>
                                @endif
                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $notification['id'] ?? '' }}"><i class="nc-icon nc-simple-remove"></i> Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No notifications to display.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
.notifications-header {
    background: linear-gradient(135deg, rgba(25, 118, 210, 0.95) 0%, rgba(13, 71, 161, 0.95) 100%) !important;
    color: white !important;
    padding: 25px 30px !important;
    border-radius: 16px !important;
    box-shadow: 0 2px 8px rgba(25, 118, 210, 0.08) !important;
    margin-bottom: 2rem !important;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.btn-refresh {
    background: #fff !important;
    color: #1976d2 !important;
    border: 1px solid #e3e6f3 !important;
    font-weight: 600;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(25, 118, 210, 0.05);
    transition: all 0.2s;
}
.btn-refresh:hover {
    background: #e3e6f3 !important;
    color: #1976d2 !important;
}
.notification-card {
    border-left: 6px solid #007bff;
    border-radius: 1rem;
    transition: box-shadow 0.2s, transform 0.2s;
    background: #fff;
    min-height: 160px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(44,62,80,0.07);
}
.notification-card:hover {
    box-shadow: 0 8px 24px rgba(25, 118, 210, 0.12);
    transform: translateY(-2px) scale(1.02);
    z-index: 2;
}
.notification-actions .btn {
    margin-right: 0.5rem;
    font-size: 0.85rem;
    border-radius: 6px;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
}
.notification-actions .btn:last-child {
    margin-right: 0;
}
.mark-read-btn {
    background: #46c35f !important;
    color: #fff !important;
    border: none !important;
}
.mark-read-btn:hover {
    background: #2e7d32 !important;
    color: #fff !important;
}
.delete-btn {
    background: #e53e3e !important;
    color: #fff !important;
    border: none !important;
}
.delete-btn:hover {
    background: #b71c1c !important;
    color: #fff !important;
}
.notification-icon {
    font-size: 2.5rem;
    color: #007bff;
    flex-shrink: 0;
    margin-top: 0.2rem;
}
.notification-warning .notification-icon { color: #ffc107; }
.notification-info .notification-icon { color: #17a2b8; }
.notification-success .notification-icon { color: #28a745; }
.card-title { font-weight: 700; }
.card-text { font-size: 1.05rem; }
.notifications-page-container {
    margin-top: 100px !important;
    min-height: 80vh;
    background: #f8f9fa;
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(44,62,80,0.04);
    padding-top: 40px;
}
.notifications-header h2 {
    color: white !important;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}
.notifications-header .badge {
    background: #1976d2 !important;
    color: white !important;
    font-size: 1.1rem;
    font-weight: 600;
    margin-left: 1.5rem;
}
@media (max-width: 768px) {
    .notifications-page-container {
        margin-top: 80px !important;
        padding-top: 20px;
    }
    .notifications-header {
        padding: 18px 10px !important;
        font-size: 1.1rem;
    }
}
</style>
@endpush
@push('js')
<script>
function showLoadingSpinner() {
    document.getElementById('refreshNotifications').innerHTML = '<i class="fa fa-spinner fa-spin"></i> Refresh';
    document.getElementById('refreshNotifications').disabled = true;
}
function hideLoadingSpinner() {
    document.getElementById('refreshNotifications').innerHTML = '<i class="nc-icon nc-refresh-69"></i> Refresh';
    document.getElementById('refreshNotifications').disabled = false;
}
function reloadNotifications() {
    showLoadingSpinner();
    fetch('/retailer/notifications', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        let notifications = data.notifications && data.notifications.data ? data.notifications.data : [];
        let html = '';
        if (notifications.length > 0) {
            notifications.forEach(function(notification) {
                html += `<div class=\"col-md-6 col-lg-4 mb-4 notification-card-col\" data-id=\"${notification.id || ''}\">\n` +
                    `<div class=\"card shadow-sm notification-card notification-${notification.type} animate__animated animate__fadeInUp\">\n` +
                    `<div class=\"card-body d-flex align-items-start\">\n` +
                    `<div class=\"notification-icon mr-3\"><i class=\"${notification.icon}\"></i></div>\n` +
                    `<div class=\"notification-content flex-grow-1\">\n` +
                    `<h5 class=\"card-title mb-1\">${notification.title}</h5>\n` +
                    `<p class=\"card-text mb-2\">${notification.text}</p>\n` +
                    `<div class=\"d-flex justify-content-between align-items-center mb-2\">\n` +
                    `<small class=\"text-muted\">${notification.time}</small>\n` +
                    (notification.link && notification.link !== '#' ? `<a href=\"${notification.link}\" class=\"btn btn-sm btn-outline-primary ml-2\" target=\"_blank\">View</a>` : '') +
                    `</div>\n` +
                    `<div class=\"notification-actions d-flex gap-2\">\n` +
                    (notification.is_read === false ? `<button class=\"btn btn-sm btn-success mark-read-btn\" data-id=\"${notification.id}\"><i class=\"nc-icon nc-check-2\"></i> Mark as Read</button>` : '') +
                    `<button class=\"btn btn-sm btn-danger delete-btn\" data-id=\"${notification.id}\"><i class=\"nc-icon nc-simple-remove\"></i> Delete</button>\n` +
                    `</div>\n` +
                    `</div>\n` +
                    `</div>\n` +
                    `</div>\n` +
                    `</div>\n`;
            });
        } else {
            html = `<div class=\"col-12\"><div class=\"alert alert-info text-center\">No notifications to display.</div></div>`;
        }
        document.getElementById('notificationsList').innerHTML = html;
        hideLoadingSpinner();
    })
    .catch(() => {
        hideLoadingSpinner();
        alert('Failed to refresh notifications.');
    });
}
document.getElementById('refreshNotifications').addEventListener('click', reloadNotifications);
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('mark-read-btn')) {
        let id = e.target.getAttribute('data-id');
        fetch(`/retailer/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin'
        })
        .then(res => res.json())
        .then(() => reloadNotifications());
    }
    if (e.target.classList.contains('delete-btn')) {
        let id = e.target.getAttribute('data-id');
        if (confirm('Delete this notification?')) {
            fetch(`/retailer/notifications/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
            .then(res => res.json())
            .then(() => reloadNotifications());
        }
    }
});
</script>
@endpush 