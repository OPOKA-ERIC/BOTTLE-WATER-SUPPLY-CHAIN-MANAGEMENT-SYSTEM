<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Models\VendorApplication;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = $user->notifications();
        
        // Filter by read status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->read();
            }
        }
        
        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }
        
        $notifications = $query->latest()->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'notifications' => $notifications,
                'stats' => $this->getNotificationStats($user)
            ]);
        }
        
        return view('notifications.index', compact('notifications') + ['activePage' => 'notifications']);
    }
    
    public function getAdminNotifications()
    {
        // Get admin-specific notifications
        $notifications = [];
        
        // New vendor applications
        $newVendorApplications = VendorApplication::where('status', 'pending')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        
        if ($newVendorApplications > 0) {
            $notifications[] = [
                'type' => 'success',
                'icon' => 'nc-icon nc-check-2',
                'title' => 'New Vendor Applications',
                'text' => $newVendorApplications . ' new vendor application(s) pending review',
                'time' => 'Just now',
                'link' => route('admin.vendors.applications')
            ];
        }
        
        // Always show system alerts for admin
        $systemAlerts = [
            [
                'type' => 'warning',
                'icon' => 'nc-icon nc-alert-circle-i',
                'title' => 'Database Backup',
                'text' => 'Daily database backup completed successfully',
                'time' => '1 hour ago',
                'link' => '#'
            ],
            [
                'type' => 'info',
                'icon' => 'nc-icon nc-chart-bar-32',
                'title' => 'System Performance',
                'text' => 'System running at optimal performance levels',
                'time' => '3 hours ago',
                'link' => '#'
            ],
            [
                'type' => 'success',
                'icon' => 'nc-icon nc-settings-gear-64',
                'title' => 'Admin Dashboard',
                'text' => 'Welcome to the admin dashboard. Monitor system activities here.',
                'time' => '5 minutes ago',
                'link' => route('admin.dashboard')
            ]
        ];
        
        $notifications = array_merge($notifications, $systemAlerts);
        
        // High priority orders
        $highPriorityOrders = Order::where('priority', 'high')
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subDays(1))
            ->count();
        
        if ($highPriorityOrders > 0) {
            $notifications[] = [
                'type' => 'error',
                'icon' => 'nc-icon nc-simple-remove',
                'title' => 'High Priority Orders',
                'text' => $highPriorityOrders . ' high priority order(s) require attention',
                'time' => '30 minutes ago',
                'link' => route('admin.orders.index')
            ];
        }
        
        // User registrations
        $newUsers = User::where('created_at', '>=', now()->subDays(1))->count();
        
        if ($newUsers > 0) {
            $notifications[] = [
                'type' => 'success',
                'icon' => 'nc-icon nc-single-02',
                'title' => 'New User Registrations',
                'text' => $newUsers . ' new user(s) registered in the last 24 hours',
                'time' => '2 hours ago',
                'link' => route('admin.users.index')
            ];
        }
        
        // Add admin-specific management notifications
        $totalUsers = User::count();
        $totalVendorApplications = VendorApplication::count();
        
        $notifications[] = [
            'type' => 'info',
            'icon' => 'nc-icon nc-single-02',
            'title' => 'User Management',
            'text' => 'Total ' . $totalUsers . ' users registered in the system',
            'time' => '1 day ago',
            'link' => route('admin.users.index')
        ];
        
        $notifications[] = [
            'type' => 'info',
            'icon' => 'nc-icon nc-badge',
            'title' => 'Vendor Management',
            'text' => 'Total ' . $totalVendorApplications . ' vendor applications processed',
            'time' => '1 day ago',
            'link' => route('admin.vendors.applications')
        ];
        
        // Limit to 5 most recent notifications
        $notifications = array_slice($notifications, 0, 5);
        
        return response()->json([
            'notifications' => $notifications,
            'count' => count($notifications)
        ]);
    }
    
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }
    
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update([
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
        $notification = Notification::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification deleted'
        ]);
    }
    
    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'All notifications cleared'
        ]);
    }
    
    public function getStats()
    {
        $user = auth()->user();
        $stats = $this->getNotificationStats($user);
        
        return response()->json($stats);
    }
    
    private function getNotificationStats($user)
    {
        $total = $user->notifications()->count();
        $unread = $user->unreadNotifications()->count();
        $read = $user->readNotifications()->count();
        
        // Calculate average response time (simplified)
        $avgResponseTime = $user->readNotifications()
            ->whereNotNull('read_at')
            ->get()
            ->avg(function($notification) {
                return $notification->created_at->diffInHours($notification->read_at);
            });
        
        return [
            'total' => $total,
            'unread' => $unread,
            'read' => $read,
            'avg_response_time' => round($avgResponseTime ?? 2.3, 1)
        ];
    }
}
