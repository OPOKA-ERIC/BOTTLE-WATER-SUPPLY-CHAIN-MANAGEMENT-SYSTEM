<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $stats = $this->getNotificationStats();

        return view('supplier.notifications', compact('notifications', 'stats'))
            ->with('title', 'Supplier Notifications - BWSCMS')
            ->with('activePage', 'notifications')
            ->with('navName', 'Notifications');
    }

    public function getNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'priority' => $notification->priority,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'data' => $notification->data
                ];
            });

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    public function getStats()
    {
        $stats = $this->getNotificationStats();
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    public function delete($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }

    public function clearAll()
    {
        Notification::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'All notifications cleared'
        ]);
    }

    private function getNotificationStats()
    {
        $userId = Auth::id();
        
        $totalNotifications = Notification::where('user_id', $userId)->count();
        $unreadNotifications = Notification::where('user_id', $userId)->where('is_read', false)->count();
        
        // Get counts by type
        $orderNotifications = Notification::where('user_id', $userId)
            ->where('type', 'order')
            ->count();
            
        $materialNotifications = Notification::where('user_id', $userId)
            ->where('type', 'material')
            ->count();
            
        $systemNotifications = Notification::where('user_id', $userId)
            ->where('type', 'system')
            ->count();

        // Get recent activity
        $recentOrders = PurchaseOrder::where('supplier_id', $userId)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $lowStockMaterials = RawMaterial::where('supplier_id', $userId)
            ->where('quantity_available', '<=', 50)
            ->count();

        return [
            'total' => $totalNotifications,
            'unread' => $unreadNotifications,
            'orders' => $orderNotifications,
            'materials' => $materialNotifications,
            'system' => $systemNotifications,
            'recent_orders' => $recentOrders,
            'low_stock' => $lowStockMaterials
        ];
    }

    // Method to create notifications for suppliers
    public static function createNotification($userId, $title, $message, $type = 'info', $priority = 'medium', $data = [])
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'priority' => $priority,
            'data' => $data,
            'is_read' => false
        ]);
        // Broadcast event for real-time updates
        event(new \App\Events\SupplierNotificationCreated($notification, $userId));
        return $notification;
    }
} 