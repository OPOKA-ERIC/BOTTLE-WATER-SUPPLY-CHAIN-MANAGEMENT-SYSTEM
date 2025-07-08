<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\VendorApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_inventory' => Inventory::sum('quantity'),
            'pending_vendor_applications' => VendorApplication::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('retailer')->latest()->take(5)->get();
        $recentVendorApplications = VendorApplication::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'recentVendorApplications' => $recentVendorApplications,
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
        return view('admin.analytics.customer-segmentation', [
            'activePage' => 'analytics-customer-segmentation',
            'title' => 'Customer Segmentation',
            'navName' => 'Customer Segmentation',
            'segmentsData' => $segmentsData
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
} 