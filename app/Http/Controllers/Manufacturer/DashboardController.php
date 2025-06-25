<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ProductionBatch;
use App\Models\PurchaseOrder;
use App\Models\Chat;
use App\Models\DemandForecast;
use App\Models\Notification;

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

    public function analytics()
    {
        return view('manufacturer.analytics', [
            'title' => 'Manufacturer Analytics',
            'activePage' => 'analytics',
            'activeButton' => 'manufacturer',
            'navName' => 'Manufacturer Analytics'
        ]);
    }

    public function notifications()
    {
        $user = auth()->user();
        
        // Get notification statistics
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'read' => $user->readNotifications()->count(),
            'avg_response_time' => $this->calculateAvgResponseTime($user)
        ];
        
        // Get notifications with pagination
        $notifications = $user->notifications()
            ->latest()
            ->paginate(10);
            
        // Get recent activity (simplified - you can expand this)
        $recentActivity = $this->getRecentActivity();
        
        return view('manufacturer.notifications', [
            'notifications' => $notifications,
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'title' => 'Manufacturer Notifications',
            'activePage' => 'notifications',
            'activeButton' => 'manufacturer',
            'navName' => 'Manufacturer Notifications'
        ]);
    }
    
    private function calculateAvgResponseTime($user)
    {
        $readNotifications = $user->readNotifications()
            ->whereNotNull('read_at')
            ->get();
            
        if ($readNotifications->isEmpty()) {
            return 2.3; // Default value
        }
        
        $totalHours = $readNotifications->sum(function($notification) {
            return $notification->created_at->diffInHours($notification->read_at);
        });
        
        return round($totalHours / $readNotifications->count(), 1);
    }
    
    private function getRecentActivity()
    {
        $user = auth()->user();
        
        $activities = collect();
        
        // Get recent production batches
        $recentBatches = ProductionBatch::where('manufacturer_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
            
        foreach ($recentBatches as $batch) {
            $activities->push([
                'type' => 'production',
                'title' => 'Production Batch ' . $batch->id . ' ' . ucfirst($batch->status),
                'description' => 'Batch of ' . $batch->quantity . ' units',
                'time' => $batch->created_at->diffForHumans(),
                'icon' => 'nc-icon nc-box-2'
            ]);
        }
        
        // Get recent inventory updates
        $recentInventory = Inventory::where('manufacturer_id', $user->id)
            ->latest()
            ->take(2)
            ->get();
            
        foreach ($recentInventory as $inventory) {
            $activities->push([
                'type' => 'inventory',
                'title' => 'Inventory Updated',
                'description' => $inventory->product->name . ' - ' . $inventory->quantity . ' units',
                'time' => $inventory->updated_at->diffForHumans(),
                'icon' => 'nc-icon nc-box'
            ]);
        }
        
        return $activities->sortByDesc('time')->take(5);
    }
} 