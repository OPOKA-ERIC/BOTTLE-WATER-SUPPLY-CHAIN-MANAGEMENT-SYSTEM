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

    private function getBusinessAccurateKPIs()
    {
        $totalOrders = Order::count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');
        $avgInventory = Inventory::avg('quantity') ?: 0;
        $usersThisMonth = User::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        $usersLastMonth = User::whereYear('created_at', now()->subMonth()->year)->whereMonth('created_at', now()->subMonth()->month)->count();
        $userGrowthRate = $usersLastMonth > 0 ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 2) : ($usersThisMonth > 0 ? 100 : 0);
        $ordersWithTimes = Order::where('status', 'delivered')->whereNotNull('created_at')->whereNotNull('updated_at')->get();
        $avgOrderProcessingTime = $ordersWithTimes->count() > 0 ? round($ordersWithTimes->sum(fn($o) => $o->updated_at->diffInMinutes($o->created_at)) / $ordersWithTimes->count() / 60, 1) : 0;
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $taskCompletionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0;
        $totalApplications = VendorApplication::count();
        $approvedApplications = VendorApplication::where('status', 'approved')->count();
        $approvalRate = $totalApplications > 0 ? round(($approvedApplications / $totalApplications) * 100, 2) : 0;
        $revenueThisMonth = Order::where('status', 'delivered')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
        $revenueLastMonth = Order::where('status', 'delivered')
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_amount');
        $revenueGrowthRate = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 2)
            : ($revenueThisMonth > 0 ? 100 : 0);
        return [
            'total_revenue' => $totalRevenue ?? 0,
            'revenue_growth_rate' => $revenueGrowthRate,
            'order_fulfillment_rate' => $totalOrders > 0 ? round(($deliveredOrders / $totalOrders) * 100, 2) : 0,
            'inventory_turnover_rate' => $avgInventory > 0 ? round($totalRevenue / $avgInventory, 2) : 0,
            'user_growth_rate' => $userGrowthRate,
            'average_order_processing_time' => $avgOrderProcessingTime,
            'task_completion_rate' => $taskCompletionRate,
            'approval_rate' => $approvalRate,
        ];
    }

    public function index()
    {
        // Get existing stats
        $stats = [
            'total_users' => User::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_inventory' => Inventory::sum('quantity'),
            'pending_vendor_applications' => VendorApplication::where('status', 'pending')->count(),
            'total_tasks' => Task::count(),
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'in_progress_tasks' => Task::where('status', 'in_progress')->count(),
            'overdue_tasks' => Task::where('due_date', '<', now())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
            'urgent_tasks' => Task::where('priority', 'urgent')
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
            // Task Delivery/Acknowledgement Tracking
            'total_assigned_tasks' => Task::whereNotNull('assigned_to')->count(),
            'total_acknowledged_tasks' => Task::where('is_read', true)->count(),
            'total_unacknowledged_tasks' => Task::where('is_read', false)->whereNotNull('assigned_to')->count(),
        ];
        $kpis = $this->getBusinessAccurateKPIs();
        $recentOrders = Order::with('retailer')->latest()->take(5)->get();
        $recentVendorApplications = VendorApplication::with('user')->latest()->take(5)->get();
        $recentTasks = Task::with(['assignedBy', 'assignedTo'])->latest()->take(5)->get();
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
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_inventory' => Inventory::sum('quantity'),
            'total_vendor_applications' => VendorApplication::count(),
            'total_tasks' => Task::count(),
            'urgent_tasks' => Task::where('priority', 'urgent')->count(),
        ];
        $kpis = $this->getBusinessAccurateKPIs();
        return view('admin.analytics', [
            'title' => 'Analytics - BWSCMS',
            'activePage' => 'analytics',
            'navName' => 'Analytics',
            'kpis' => $kpis,
            'stats' => $stats,
        ]);
    }
    // Demo helper methods (no year/status filter)
    private function calculateRevenueGrowthRateDemo() {
        $all = Order::sum('total_amount');
        return $all > 0 ? 100 : 0;
    }
    private function calculateOrderFulfillmentRateDemo() {
        $total = Order::count();
        $fulfilled = Order::count();
        return $total > 0 ? round(($fulfilled / $total) * 100, 2) : 0;
    }
    private function calculateInventoryTurnoverRateDemo() {
        $totalSold = Order::sum('total_amount');
        $avgInventory = Inventory::avg('quantity');
        return $avgInventory > 0 ? round($totalSold / $avgInventory, 2) : 0;
    }
    private function calculateUserGrowthRateDemo() {
        $total = User::count();
        return $total > 0 ? 100 : 0;
    }
    private function calculateAverageOrderProcessingTimeDemo() {
        $orders = Order::whereNotNull('created_at')->whereNotNull('updated_at')->get();
        if ($orders->count() == 0) return 0;
        $totalMinutes = $orders->sum(function($order) {
            return $order->updated_at->diffInMinutes($order->created_at);
        });
        return round($totalMinutes / $orders->count(), 2);
    }
    private function calculateTaskCompletionRateDemo() {
        $total = Task::count();
        $completed = Task::count();
        return $total > 0 ? round(($completed / $total) * 100, 2) : 0;
    }
    private function calculateApprovalRateDemo() {
        $total = VendorApplication::count();
        $approved = VendorApplication::count();
        return $total > 0 ? round(($approved / $total) * 100, 2) : 0;
    }

    public function demandForecast()
    {
        $forecastData = [];
        $csvPath = storage_path('app/analytics/demand_forecast.csv');
        if (file_exists($csvPath)) {
            if (($handle = fopen($csvPath, 'r')) !== false) {
                $header = fgetcsv($handle);
                while (($row = fgetcsv($handle)) !== false) {
                    $forecastData[] = array_combine($header, $row);
                }
                fclose($handle);
            }
        }
        return view('admin.analytics.demand-forecast', [
            'activePage' => 'analytics-demand-forecast',
            'title' => 'Demand Forecast',
            'navName' => 'Demand Forecast',
            'forecastData' => $forecastData
        ]);
    }

    public function customerSegmentation()
    {
        $segmentsData = [];
        $csvPath = storage_path('app/analytics/customer_segments.csv');
        if (file_exists($csvPath)) {
            if (($handle = fopen($csvPath, 'r')) !== false) {
                $header = fgetcsv($handle);
                while (($row = fgetcsv($handle)) !== false) {
                    $segmentsData[] = array_combine($header, $row);
                }
                fclose($handle);
            }
        }

        // Calculate segment profiles (reuse logic from summary)
        $summary = [];
        foreach ($segmentsData as $row) {
            $segment = $row['Segment'];
            if (!isset($summary[$segment])) {
                $summary[$segment] = [
                    'count' => 0,
                    'total_quantity' => 0,
                    'total_amount' => 0,
                    'total_age' => 0,
                    'genders' => [],
                ];
            }
            $summary[$segment]['count'] += 1;
            $summary[$segment]['total_quantity'] += (int)$row['Quantity'];
            $summary[$segment]['total_amount'] += (float)$row['Total Amount'];
            $summary[$segment]['total_age'] += (int)$row['Age'];
            $summary[$segment]['genders'][] = $row['Gender'];
        }

        $segmentProfiles = [];
        foreach ($summary as $segment => $data) {
            $avg_amount = $data['count'] ? $data['total_amount'] / $data['count'] : 0;
            $avg_age = $data['count'] ? $data['total_age'] / $data['count'] : 0;
            $genderCounts = array_count_values($data['genders']);
            $most_common_gender = $genderCounts ? array_search(max($genderCounts), $genderCounts) : '';
            if ($avg_amount > 1000) {
                $profile = 'High spenders, moderate quantity, mostly ' . strtolower($most_common_gender);
            } elseif ($avg_amount > 200 && $avg_age > 50) {
                $profile = 'Older, high spend, low quantity, mostly ' . strtolower($most_common_gender);
            } elseif ($avg_amount > 200 && $avg_age < 35) {
                $profile = 'Young, low quantity, higher spend, mostly ' . strtolower($most_common_gender);
            } else {
                $profile = 'Moderate buyers, middle-aged, mostly ' . strtolower($most_common_gender);
            }
            $segmentProfiles[$segment] = $profile;
        }

        return view('admin.analytics.customer-segmentation', [
            'activePage' => 'analytics-customer-segmentation',
            'title' => 'Customer Segmentation',
            'navName' => 'Customer Segmentation',
            'segmentsData' => $segmentsData,
            'segmentProfiles' => $segmentProfiles,
        ]);
    }

    public function customerSegmentationAnalysis()
    {
        $segmentsData = [];
        $csvPath = storage_path('app/analytics/customer_segments.csv');
        if (file_exists($csvPath)) {
            if (($handle = fopen($csvPath, 'r')) !== false) {
                $header = fgetcsv($handle);
                while (($row = fgetcsv($handle)) !== false) {
                    $segmentsData[] = array_combine($header, $row);
                }
                fclose($handle);
            }
        }

        // Calculate summary
        $summary = [];
        foreach ($segmentsData as $row) {
            $segment = $row['Segment'];
            if (!isset($summary[$segment])) {
                $summary[$segment] = [
                    'count' => 0,
                    'total_quantity' => 0,
                    'total_amount' => 0,
                    'total_age' => 0,
                    'genders' => [],
                ];
            }
            $summary[$segment]['count'] += 1;
            $summary[$segment]['total_quantity'] += (int)$row['Quantity'];
            $summary[$segment]['total_amount'] += (float)$row['Total Amount'];
            $summary[$segment]['total_age'] += (int)$row['Age'];
            $summary[$segment]['genders'][] = $row['Gender'];
        }

        // Finalize averages and most common gender
        foreach ($summary as $segment => &$data) {
            $data['avg_quantity'] = $data['count'] ? $data['total_quantity'] / $data['count'] : 0;
            $data['avg_amount'] = $data['count'] ? $data['total_amount'] / $data['count'] : 0;
            $data['avg_age'] = $data['count'] ? $data['total_age'] / $data['count'] : 0;
            $genderCounts = array_count_values($data['genders']);
            $data['most_common_gender'] = $genderCounts ? array_search(max($genderCounts), $genderCounts) : '';
            unset($data['genders'], $data['total_quantity'], $data['total_amount'], $data['total_age']);
        }

        return view('admin.analytics.customer-segmentation-analysis', [
            'summary' => $summary,
            'activePage' => 'analytics-customer-segmentation-summary'
        ]);
    }

    public function customerSegmentationSummary()
    {
        $segmentsData = [];
        $csvPath = storage_path('app/analytics/customer_segments.csv');
        if (file_exists($csvPath)) {
            if (($handle = fopen($csvPath, 'r')) !== false) {
                $header = fgetcsv($handle);
                while (($row = fgetcsv($handle)) !== false) {
                    $segmentsData[] = array_combine($header, $row);
                }
                fclose($handle);
            }
        }

        // Calculate summary
        $summary = [];
        foreach ($segmentsData as $row) {
            $segment = $row['Segment'];
            if (!isset($summary[$segment])) {
                $summary[$segment] = [
                    'count' => 0,
                    'total_quantity' => 0,
                    'total_amount' => 0,
                    'total_age' => 0,
                    'genders' => [],
                ];
            }
            $summary[$segment]['count'] += 1;
            $summary[$segment]['total_quantity'] += (int)$row['Quantity'];
            $summary[$segment]['total_amount'] += (float)$row['Total Amount'];
            $summary[$segment]['total_age'] += (int)$row['Age'];
            $summary[$segment]['genders'][] = $row['Gender'];
        }

        // Finalize averages and most common gender
        foreach ($summary as $segment => &$data) {
            $data['avg_quantity'] = $data['count'] ? $data['total_quantity'] / $data['count'] : 0;
            $data['avg_amount'] = $data['count'] ? $data['total_amount'] / $data['count'] : 0;
            $data['avg_age'] = $data['count'] ? $data['total_age'] / $data['count'] : 0;
            $genderCounts = array_count_values($data['genders']);
            $data['most_common_gender'] = $genderCounts ? array_search(max($genderCounts), $genderCounts) : '';
            unset($data['genders'], $data['total_quantity'], $data['total_amount'], $data['total_age']);
        }

        return view('admin.analytics.customer-segmentation-analysis', [
            'summary' => $summary,
            'activePage' => 'analytics-customer-segmentation-summary'
        ]);
    }

    public function reports()
    {
        $user = auth()->user();
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_inventory' => \App\Models\Inventory::sum('quantity'),
            'total_vendor_applications' => \App\Models\VendorApplication::count(),
            'total_tasks' => \App\Models\Task::count(),
            'completed_tasks' => \App\Models\Task::where('status', 'completed')->count(),
            'pending_tasks' => \App\Models\Task::where('status', 'pending')->count(),
            'in_progress_tasks' => \App\Models\Task::where('status', 'in_progress')->count(),
        ];
        $recentActivities = [
            'orders' => \App\Models\Order::latest()->take(5)->get(),
            'vendor_applications' => \App\Models\VendorApplication::latest()->take(5)->get(),
            'tasks' => \App\Models\Task::latest()->take(5)->get(),
        ];
        return view('admin.reports', [
            'user' => $user,
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'title' => 'Admin Reports',
            'activePage' => 'admin-reports',
            'navName' => 'Admin Reports',
        ]);
    }

    public function downloadReport()
    {
        $user = auth()->user();
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_inventory' => \App\Models\Inventory::sum('quantity'),
            'total_vendor_applications' => \App\Models\VendorApplication::count(),
            'total_tasks' => \App\Models\Task::count(),
            'completed_tasks' => \App\Models\Task::where('status', 'completed')->count(),
            'pending_tasks' => \App\Models\Task::where('status', 'pending')->count(),
            'in_progress_tasks' => \App\Models\Task::where('status', 'in_progress')->count(),
        ];
        $recentActivities = [
            'orders' => \App\Models\Order::latest()->take(5)->get(),
            'vendor_applications' => \App\Models\VendorApplication::latest()->take(5)->get(),
            'tasks' => \App\Models\Task::latest()->take(5)->get(),
        ];
        $html = view('admin.report_pdf', [
            'user' => $user,
            'stats' => $stats,
            'recentActivities' => $recentActivities,
        ])->render();
        if (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return $pdf->download('admin_report_' . $user->id . '.pdf');
        } else {
            return response($html)->header('Content-Type', 'text/html');
        }
    }
} 