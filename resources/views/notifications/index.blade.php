@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <h2 class="mb-0"><i class="nc-icon nc-bell-55 mr-2"></i> Notifications</h2>
        <span class="badge badge-pill badge-primary ml-3" style="font-size:1.1rem;">{{ count($notifications) }}</span>
                    </div>
    <div class="row">
        @forelse($notifications as $notification)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm notification-card notification-{{ $notification['type'] }} animate__animated animate__fadeInUp">
                    <div class="card-body d-flex align-items-start">
                        <div class="notification-icon mr-3">
                            <i class="{{ $notification['icon'] }}"></i>
                        </div>
                        <div class="notification-content">
                            <h5 class="card-title mb-1">{{ $notification['title'] }}</h5>
                            <p class="card-text mb-2">{{ $notification['text'] }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $notification['time'] }}</small>
                                @if(!empty($notification['link']) && $notification['link'] !== '#')
                                    <a href="{{ $notification['link'] }}" class="btn btn-sm btn-outline-primary ml-2" target="_blank">View</a>
                                @endif
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
.notification-card {
    border-left: 6px solid #007bff;
    border-radius: 1rem;
    transition: box-shadow 0.2s;
    background: #fff;
    min-height: 160px;
    position: relative;
    overflow: hidden;
}
.notification-warning { border-left-color: #ffc107; }
.notification-info { border-left-color: #17a2b8; }
.notification-success { border-left-color: #28a745; }
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
.notification-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    transform: translateY(-2px) scale(1.02);
    z-index: 2;
}
</style>
@endpush 