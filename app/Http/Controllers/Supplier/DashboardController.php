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
        try {
            // Validate the request
            $request->validate([
                'quantity_available' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'status' => 'required|string|in:available,low_stock,unavailable',
            ]);

            // Find the material and ensure it belongs to the authenticated supplier
            $material = RawMaterial::where('id', $id)
                ->where('supplier_id', auth()->id())
                ->firstOrFail();

            // Update the material
        $material->update([
            'quantity_available' => $request->quantity_available,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Material updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating material: ' . $e->getMessage());
        }
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

    public function apiMaterials()
    {
        $materials = RawMaterial::where('supplier_id', auth()->id())->paginate(10);
        $total_value = collect($materials->items())->sum(function($m) {
            return $m->quantity_available * $m->price;
        });
        return response()->json([
            'materials' => $materials->items(),
            'total' => $materials->total(),
            'available' => collect($materials->items())->where('status', 'available')->count(),
            'low_stock' => collect($materials->items())->where('status', 'low_stock')->count(),
            'total_value' => $total_value,
        ]);
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|in:bottles,bottle lids,boxes for packing,water,paper',
            'description' => 'nullable|string',
            'quantity_available' => 'required|numeric|min:0',
            'unit_of_measure' => 'required|string',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        RawMaterial::create([
            'supplier_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'quantity_available' => $request->quantity_available,
            'unit_of_measure' => $request->unit_of_measure,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Material added successfully!');
    }

    public function reports()
    {
        $user = auth()->user();
        $orders = \App\Models\PurchaseOrder::where('supplier_id', $user->id)->with('manufacturer')->orderBy('created_at', 'desc')->get();
        $materials = \App\Models\RawMaterial::where('supplier_id', $user->id)->get();
        $totalSales = $orders->where('status', 'completed')->sum('total_amount');
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $stats = [
            'total_sales' => $totalSales,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'total_materials' => $materials->count(),
        ];
        return view('supplier.reports', [
            'user' => $user,
            'orders' => $orders,
            'materials' => $materials,
            'stats' => $stats,
            'title' => 'Supplier Reports',
            'activePage' => 'reports',
            'navName' => 'Supplier Reports',
        ]);
    }

    public function downloadReport()
    {
        $user = auth()->user();
        $orders = \App\Models\PurchaseOrder::where('supplier_id', $user->id)->with('manufacturer')->orderBy('created_at', 'desc')->get();
        $materials = \App\Models\RawMaterial::where('supplier_id', $user->id)->get();
        $totalSales = $orders->where('status', 'completed')->sum('total_amount');
        $pendingOrders = $orders->where('status', 'pending')->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $stats = [
            'total_sales' => $totalSales,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'total_materials' => $materials->count(),
        ];
        $html = view('supplier.report_pdf', [
            'user' => $user,
            'orders' => $orders,
            'materials' => $materials,
            'stats' => $stats,
        ])->render();
        if (class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
            return $pdf->download('supplier_report_' . $user->id . '.pdf');
        } else {
            return response($html)->header('Content-Type', 'text/html');
        }
    }
} 