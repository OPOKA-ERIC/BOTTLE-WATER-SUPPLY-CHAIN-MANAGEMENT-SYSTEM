<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\VendorApplication;
use App\Models\Task;
// use App\Services\KPIService;

class DashboardController extends Controller
{
    // protected $kpiService;

    // public function __construct(KPIService $kpiService)
    // {
    //     $this->kpiService = $kpiService;
    // }

    public function index()
    {
        // Get existing stats
        $stats = [
            'total_users' => User::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_inventory' => Inventory::sum('quantity'),
            'pending_vendor_applications' => VendorApplication::where('status', 'pending')->count(),
            // Task Management Statistics
            'total_tasks' => Task::count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'in_progress_tasks' => Task::where('status', 'in_progress')->count(),
            'overdue_tasks' => Task::where('due_date', '<', now())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
            'urgent_tasks' => Task::where('priority', 'urgent')
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
        ];

        // Get professional KPIs - temporarily disabled for debugging
        // $kpis = $this->kpiService->getAdminKPIs();
        $kpis = [
            'total_revenue' => 1250000.50,
            'revenue_growth_rate' => 12.5,
            'order_fulfillment_rate' => 94.8,
            'inventory_turnover_rate' => 8.2,
            'user_growth_rate' => 15.3,
            'average_order_processing_time' => 4.2,
            'task_completion_rate' => 87.6,
            'approval_rate' => 72.4,
        ];

        $recentOrders = Order::with('retailer')->latest()->take(5)->get();
        $recentVendorApplications = VendorApplication::with('user')->latest()->take(5)->get();
        
        // Recent Tasks for Dashboard
        $recentTasks = Task::with(['assignedBy', 'assignedTo'])
            ->latest()
            ->take(5)
            ->get();
            
        // Workload Distribution
        $workloadDistribution = User::where('role', '!=', 'administrator')
            ->withCount(['assignedTasks as total_tasks' => function($query) {
                $query->whereNotIn('status', ['completed', 'cancelled']);
            }])
            ->withCount(['assignedTasks as pending_tasks' => function($query) {
                $query->where('status', 'pending');
            }])
            ->withCount(['assignedTasks as in_progress_tasks' => function($query) {
                $query->where('status', 'in_progress');
            }])
            ->get()
            ->map(function($user) {
                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'total_tasks' => $user->total_tasks,
                    'pending_tasks' => $user->pending_tasks,
                    'in_progress_tasks' => $user->in_progress_tasks,
                    'workload_percentage' => $user->total_tasks > 0 ? ($user->in_progress_tasks / $user->total_tasks) * 100 : 0,
                ];
            });

        return view('admin.dashboard', [
            'stats' => $stats,
            'kpis' => $kpis,
            'recentOrders' => $recentOrders,
            'recentVendorApplications' => $recentVendorApplications,
            'recentTasks' => $recentTasks,
            'workloadDistribution' => $workloadDistribution,
            'title' => 'Admin Dashboard - BWSCMS',
            'activePage' => 'dashboard-overview',
            'navName' => 'Admin Dashboard'
        ]);
    }

    public function userManagement()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'))
            ->with('title', 'User Management - BWSCMS')
            ->with('activePage', 'user-management')
            ->with('navName', 'User Management');
    }

    public function orders()
    {
        $orders = Order::with('retailer')->paginate(10);
        return view('admin.orders.index', compact('orders'))
            ->with('title', 'Order Management - BWSCMS')
            ->with('activePage', 'order-management')
            ->with('navName', 'Order Management');
    }

    public function vendorApplications()
    {
        $applications = VendorApplication::with('user')->paginate(10);
        return view('admin.vendors.applications', [
            'applications' => $applications,
            'title' => 'Vendor Applications',
            'activePage' => 'vendor-applications',
            'activeButton' => 'laravel',
            'navName' => 'Vendor Applications',
        ]);
    }

    public function approveVendorApplication($id)
    {
        $application = VendorApplication::findOrFail($id);
        $application->update(['status' => 'approved']);
        $application->user->update(['role' => 'supplier']);

        return redirect()->back()->with('success', 'Vendor application approved successfully');
    }

    public function rejectVendorApplication($id)
    {
        $application = VendorApplication::findOrFail($id);
        $application->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Vendor application rejected');
    }

    public function analytics()
    {
        return view('admin.analytics', [
            'title' => 'Analytics - BWSCMS',
            'activePage' => 'analytics',
            'navName' => 'Analytics',
        ]);
    }
} 