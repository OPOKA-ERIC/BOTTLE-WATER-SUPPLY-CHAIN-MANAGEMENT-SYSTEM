<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ProductionBatch;
use App\Models\PurchaseOrder;
use App\Models\Chat;
use App\Models\DemandForecast;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_inventory' => Inventory::where('manufacturer_id', auth()->id())->sum('quantity'),
            'pending_orders' => PurchaseOrder::where('manufacturer_id', auth()->id())
                ->where('status', 'pending')
                ->count(),
            'total_production' => ProductionBatch::where('manufacturer_id', auth()->id())
                ->where('status', 'completed')
                ->sum('quantity'),
        ];

        $recentBatches = ProductionBatch::where('manufacturer_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $demandForecast = DemandForecast::where('manufacturer_id', auth()->id())
            ->latest()
            ->first();

        return view('manufacturer.dashboard', [
            'stats' => $stats,
            'recentBatches' => $recentBatches,
            'demandForecast' => $demandForecast,
            'title' => 'Manufacturer Dashboard',
            'activePage' => 'dashboard',
            'activeButton' => 'manufacturer',
            'navName' => 'Manufacturer Dashboard'
        ]);
    }

    public function inventory()
    {
        $inventory = Inventory::where('manufacturer_id', auth()->id())->paginate(10);
        return view('manufacturer.inventory.index', [
            'inventory' => $inventory,
            'title' => 'Inventory Management',
            'activePage' => 'inventory',
            'activeButton' => 'manufacturer',
            'navName' => 'Inventory Management'
        ]);
    }

    public function updateInventory(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->update([
            'quantity' => $request->quantity,
            'expiry_date' => $request->expiry_date,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Inventory updated successfully');
    }

    public function productionBatches()
    {
        $batches = ProductionBatch::where('manufacturer_id', auth()->id())
            ->with('product')
            ->paginate(10);
        return view('manufacturer.production.batches', [
            'batches' => $batches,
            'title' => 'Production Batches',
            'activePage' => 'production',
            'activeButton' => 'manufacturer',
            'navName' => 'Production Batches'
        ]);
    }

    public function createProductionBatch(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'production_date' => 'required|date',
        ]);

        ProductionBatch::create([
            'manufacturer_id' => auth()->id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'production_date' => $request->production_date,
            'status' => 'in_progress',
        ]);

        return redirect()->back()->with('success', 'Production batch created successfully');
    }

    public function chatWithSupplier($supplierId)
    {
        $chats = Chat::where('manufacturer_id', auth()->id())
            ->where('supplier_id', $supplierId)
            ->with('supplier')
            ->latest()
            ->paginate(20);

        return view('manufacturer.chat.index', [
            'chats' => $chats,
            'supplierId' => $supplierId,
            'title' => 'Chat with Supplier',
            'activePage' => 'chat',
            'activeButton' => 'manufacturer',
            'navName' => 'Chat with Supplier'
        ]);
    }
} 