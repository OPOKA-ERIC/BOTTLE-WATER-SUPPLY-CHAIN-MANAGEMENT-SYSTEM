<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RawMaterial;
use App\Models\VendorApplication;
use App\Models\PurchaseOrder;
use App\Models\Chat;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_materials' => RawMaterial::where('supplier_id', auth()->id())->count(),
            'pending_orders' => PurchaseOrder::where('supplier_id', auth()->id())
                ->where('status', 'pending')
                ->count(),
            'total_sales' => PurchaseOrder::where('supplier_id', auth()->id())
                ->where('status', 'completed')
                ->sum('total_amount'),
        ];

        $recentOrders = PurchaseOrder::where('supplier_id', auth()->id())
            ->with('manufacturer')
            ->latest()
            ->take(5)
            ->get();

        $recentChats = Chat::where('supplier_id', auth()->id())
            ->with('manufacturer')
            ->latest()
            ->take(5)
            ->get();

        return view('supplier.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'recentChats' => $recentChats,
            'title' => 'Supplier Dashboard',
            'activePage' => 'dashboard',
            'activeButton' => 'supplier',
            'navName' => 'Supplier Dashboard'
        ]);
    }

    public function materials()
    {
        $materials = RawMaterial::where('supplier_id', auth()->id())->paginate(10);
        return view('supplier.materials.index', compact('materials'))
            ->with('title', 'Supplier Materials - BWSCMS')
            ->with('activePage', 'materials')
            ->with('navName', 'Raw Materials');
    }

    public function updateMaterial(Request $request, $id)
    {
        $material = RawMaterial::findOrFail($id);
        $material->update([
            'quantity' => $request->quantity,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Material updated successfully');
    }

    public function submitVendorApplication(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'document' => 'required|file|mimes:pdf|max:10240',
            'description' => 'required',
        ]);

        $path = $request->file('document')->store('vendor-applications');

        VendorApplication::create([
            'user_id' => auth()->id(),
            'company_name' => $request->company_name,
            'document_path' => $path,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully');
    }
} 