<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

class SupplierNotificationCreated implements ShouldBroadcast
{
    use SerializesModels;

    public $notification;
    public $userId;

    public function __construct(Notification $notification, $userId)
    {
        $this->notification = $notification;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('supplier.notifications.' . $this->userId);
    }
} 