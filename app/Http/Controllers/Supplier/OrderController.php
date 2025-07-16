<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;

class OrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::where('supplier_id', auth()->id())
            ->with(['manufacturer', 'rawMaterials'])
            ->latest()
            ->paginate(10);

        return view('supplier.orders.index', compact('orders'))
            ->with('title', 'Supplier Orders - BWSCMS')
            ->with('activePage', 'orders')
            ->with('navName', 'Supplier Orders');
    }

    public function show($id)
    {
        $order = PurchaseOrder::where('supplier_id', auth()->id())
            ->with(['manufacturer', 'items.rawMaterial'])
            ->findOrFail($id);

        return view('supplier.orders.show', compact('order'))
            ->with('title', 'Order Details - BWSCMS')
            ->with('activePage', 'orders')
            ->with('navName', 'Order Details');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = PurchaseOrder::where('supplier_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }
} 