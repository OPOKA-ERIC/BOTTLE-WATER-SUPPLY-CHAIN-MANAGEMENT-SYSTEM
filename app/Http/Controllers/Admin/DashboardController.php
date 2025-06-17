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

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentVendorApplications = VendorApplication::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'recentVendorApplications' => $recentVendorApplications,
            'title' => 'Admin Dashboard',
            'activePage' => 'dashboard',
        ]);
    }

    public function userManagement()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function vendorApplications()
    {
        $applications = VendorApplication::with('user')->paginate(10);
        return view('admin.vendors.applications', compact('applications'));
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
} 