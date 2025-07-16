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
use App\Models\Order;

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

        // Get recent orders that need processing
        $recentOrders = \App\Models\Order::with(['retailer', 'products', 'deliverySchedule'])
            ->whereIn('status', ['pending', 'processing'])
            ->latest()
            ->take(5)
            ->get();

        $demandForecast = DemandForecast::where('manufacturer_id', auth()->id())
            ->latest()
            ->first();

        return view('manufacturer.dashboard', [
            'stats' => $stats,
            'recentBatches' => $recentBatches,
            'recentOrders' => $recentOrders,
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
        $products = \App\Models\Product::where('status', 'active')->get();
        
        return view('manufacturer.inventory.index', [
            'inventory' => $inventory,
            'products' => $products,
            'title' => 'Inventory Management',
            'activePage' => 'inventory',
            'activeButton' => 'manufacturer',
            'navName' => 'Inventory Management'
        ]);
    }

    public function updateInventory(Request $request, $id)
    {
        $request->validate([
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $inventory = Inventory::where('manufacturer_id', auth()->id())->findOrFail($id);
            
            $inventory->update([
                'current_stock' => $request->current_stock,
                'minimum_stock' => $request->minimum_stock,
                'quantity' => $request->current_stock, // Keep quantity in sync
                'notes' => $request->notes,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Inventory updated successfully',
                    'inventory' => $inventory->fresh()
                ]);
            }

            return redirect()->back()->with('success', 'Inventory updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update inventory: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update inventory');
        }
    }

    public function inventoryHistory($id)
    {
        try {
            $inventory = Inventory::where('manufacturer_id', auth()->id())
                ->with('product')
                ->findOrFail($id);

            // For now, we'll return the current inventory data
            // In a real application, you might want to track inventory changes in a separate table
            // For demonstration, we'll create a simple history array with the current state
            $history = [
                [
                    'current_stock' => $inventory->current_stock,
                    'minimum_stock' => $inventory->minimum_stock,
                    'notes' => $inventory->notes,
                    'updated_at' => $inventory->updated_at
                ]
            ];

            return response()->json([
                'success' => true,
                'inventory' => $inventory,
                'history' => $history
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load history: ' . $e->getMessage()
            ], 500);
        }
    }

    public function productionBatches()
    {
        $batches = ProductionBatch::where('manufacturer_id', auth()->id())
            ->with('product')
            ->paginate(10);
            
        $products = \App\Models\Product::where('status', 'active')->get();
        
        return view('manufacturer.production.batches', [
            'batches' => $batches,
            'products' => $products,
            'title' => 'Production Batches',
            'activePage' => 'production',
            'activeButton' => 'manufacturer',
            'navName' => 'Production Batches'
        ]);
    }

    public function createProductionBatch(Request $request)
    {
        // Log the request data for debugging
        \Log::info('Production batch creation request', [
            'data' => $request->all(),
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role ?? 'not set',
            'has_ajax' => $request->ajax(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        // Check if user is authenticated and has correct role
        if (!auth()->check()) {
            \Log::error('User not authenticated for production batch creation');
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'manufacturer') {
            \Log::error('User does not have manufacturer role', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role
            ]);
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'estimated_completion' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $batch = ProductionBatch::create([
                'manufacturer_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'production_date' => $request->start_date,
                'start_date' => $request->start_date,
                'estimated_completion' => $request->estimated_completion,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Log successful creation
            \Log::info('Production batch created successfully', [
                'batch_id' => $batch->id,
                'user_id' => auth()->id()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Production batch created successfully',
                    'batch' => $batch->load('product'),
                    'redirect' => route('manufacturer.production.batches')
                ]);
            }

            return redirect()->back()->with('success', 'Production batch created successfully');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to create production batch', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create production batch: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to create production batch');
        }
    }

    public function updateBatchStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        try {
            $batch = ProductionBatch::where('manufacturer_id', auth()->id())
                ->findOrFail($id);

            $batch->update([
                'status' => $request->status,
                'completed_at' => $request->status === 'completed' ? now() : null,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Batch status updated successfully',
                    'batch' => $batch->load('product')
                ]);
            }

            return redirect()->back()->with('success', 'Batch status updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update batch status: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update batch status');
        }
    }

    public function getBatchesData()
    {
        try {
            $batches = ProductionBatch::where('manufacturer_id', auth()->id())
                ->with('product')
                ->latest()
                ->get();

            $stats = [
                'total_batches' => $batches->count(),
                'in_progress' => $batches->where('status', 'in_progress')->count(),
                'completed' => $batches->where('status', 'completed')->count(),
                'total_quantity' => $batches->sum('quantity'),
            ];

            return response()->json([
                'success' => true,
                'batches' => $batches,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch batches data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getBatchDetails($id)
    {
        try {
            $batch = ProductionBatch::where('manufacturer_id', auth()->id())
                ->with('product')
                ->findOrFail($id);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'batch' => $batch
                ]);
            }

            return view('manufacturer.production.batch-details', [
                'batch' => $batch,
                'title' => 'Batch Details',
                'activePage' => 'production',
                'activeButton' => 'manufacturer',
                'navName' => 'Batch Details'
            ]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch batch details: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to fetch batch details');
        }
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
        $manufacturerId = auth()->id();
        
        // Get production batches data
        $productionBatches = ProductionBatch::where('manufacturer_id', $manufacturerId)->get();
        $inventory = Inventory::where('manufacturer_id', $manufacturerId)->get();
        
        // Calculate real-time KPIs
        $totalBatches = $productionBatches->count();
        $completedBatches = $productionBatches->where('status', 'completed')->count();
        $inProgressBatches = $productionBatches->where('status', 'in_progress')->count();
        $totalProduction = $productionBatches->where('status', 'completed')->sum('quantity');
        
        // Calculate production efficiency
        $efficiency = $totalBatches > 0 ? round(($completedBatches / $totalBatches) * 100, 1) : 0;
        
        // Calculate average cycle time (improved calculation)
        $avgCycleTime = 0;
        $completedBatches = $productionBatches->where('status', 'completed');
        
        if ($completedBatches->count() > 0) {
            $totalHours = 0;
            $validBatches = 0;
            
            foreach ($completedBatches as $batch) {
                // Use completed_at if available, otherwise use updated_at as fallback
                $completionDate = $batch->completed_at ?? $batch->updated_at;
                $startDate = $batch->start_date;
                
                if ($startDate && $completionDate) {
                    $start = \Carbon\Carbon::parse($startDate);
                    $completion = \Carbon\Carbon::parse($completionDate);
                    
                    // Only count if completion is after start
                    if ($completion->gt($start)) {
                        $totalHours += $start->diffInHours($completion);
                        $validBatches++;
                    }
                }
            }
            
            $avgCycleTime = $validBatches > 0 ? round($totalHours / $validBatches, 1) : 0;
        }
        
        // Calculate revenue in Ugandan Shillings (UGX) based on real production data
        // Product-specific pricing in UGX (actual pricing structure)
        $productPricing = [
            'Mineral Water 500ml' => 500,   // 500 UGX per bottle
            'Mineral Water 1L' => 1000,     // 1,000 UGX per bottle
            'Mineral Water 5L' => 5000,     // 5,000 UGX per bottle
            'default' => 500                // Default price for unknown products
        ];
        
        $revenueUGX = 0;
        $totalUnits = 0;
        
        // Calculate revenue based on actual products produced
        foreach ($productionBatches->where('status', 'completed') as $batch) {
            $productName = $batch->product->name ?? 'default';
            $unitPrice = $productPricing[$productName] ?? $productPricing['default'];
            $batchRevenue = $batch->quantity * $unitPrice;
            $revenueUGX += $batchRevenue;
            $totalUnits += $batch->quantity;
        }
        
        // Calculate average price per unit for analytics
        $avgPricePerUnitUGX = $totalUnits > 0 ? $revenueUGX / $totalUnits : 500;
        
        // Also calculate in USD for reference (approximate exchange rate: 1 USD = 3,800 UGX)
        $exchangeRate = 3800;
        $revenueUSD = $revenueUGX / $exchangeRate;
        
        // Get monthly production data for charts (improved calculation)
        $monthlyProduction = [];
        for ($i = 3; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthKey = $month->format('M Y');
            $monthProduction = $productionBatches
                ->where('status', 'completed')
                ->filter(function ($batch) use ($month) {
                    // Use completed_at if available, otherwise use updated_at
                    $completionDate = $batch->completed_at ?? $batch->updated_at;
                    return $completionDate && \Carbon\Carbon::parse($completionDate)->format('Y-m') === $month->format('Y-m');
                })
                ->sum('quantity');
            $monthlyProduction[$monthKey] = $monthProduction;
        }
        
        // Get top performing products
        $topProducts = $productionBatches
            ->where('status', 'completed')
            ->groupBy('product_id')
            ->map(function ($batches) {
                return [
                    'product' => $batches->first()->product,
                    'total_quantity' => $batches->sum('quantity'),
                    'batch_count' => $batches->count()
                ];
            })
            ->sortByDesc('total_quantity')
            ->take(5);
        
        // Calculate inventory metrics
        $totalInventoryValue = $inventory->sum('current_stock');
        $lowStockItems = $inventory->where('current_stock', '<=', 'minimum_stock')->count();
        $inventoryUtilization = $inventory->count() > 0 ? 
            round(($inventory->where('current_stock', '>', 'minimum_stock')->count() / $inventory->count()) * 100, 1) : 0;
        
        // Get recent alerts
        $recentAlerts = [];
        
        // Low inventory alerts
        $lowStockInventory = $inventory->where('current_stock', '<=', 'minimum_stock');
        foreach ($lowStockInventory as $item) {
            $recentAlerts[] = [
                'type' => 'warning',
                'title' => 'Low Inventory Alert',
                'message' => $item->product->name . ' is running low. Current stock: ' . $item->current_stock . ' ' . $item->unit,
                'time' => 'Just now',
                'icon' => 'nc-icon nc-alert-circle-i'
            ];
        }
        
        // Production efficiency alerts
        if ($efficiency < 80) {
            $recentAlerts[] = [
                'type' => 'info',
                'title' => 'Efficiency Improvement Needed',
                'message' => 'Production efficiency is at ' . $efficiency . '%. Consider optimizing processes.',
                'time' => '1 hour ago',
                'icon' => 'nc-icon nc-chart-bar-32'
            ];
        } else {
            $recentAlerts[] = [
                'type' => 'success',
                'title' => 'Excellent Efficiency',
                'message' => 'Production efficiency is at ' . $efficiency . '%. Keep up the great work!',
                'time' => '2 hours ago',
                'icon' => 'nc-icon nc-check-2'
            ];
        }
        
        // Production target alerts
        if ($totalProduction > 10000) {
            $recentAlerts[] = [
                'type' => 'success',
                'title' => 'Production Target Met',
                'message' => 'Monthly production target achieved! Total: ' . number_format($totalProduction) . ' units',
                'time' => '1 day ago',
                'icon' => 'nc-icon nc-check-2'
            ];
        }
        
        // Calculate trends
        $currentMonthProduction = $productionBatches
            ->where('status', 'completed')
            ->filter(function ($batch) {
                return \Carbon\Carbon::parse($batch->completed_at)->format('Y-m') === now()->format('Y-m');
            })
            ->sum('quantity');
        
        $lastMonthProduction = $productionBatches
            ->where('status', 'completed')
            ->filter(function ($batch) {
                return \Carbon\Carbon::parse($batch->completed_at)->format('Y-m') === now()->subMonth()->format('Y-m');
            })
            ->sum('quantity');
        
        $productionTrend = $lastMonthProduction > 0 ? 
            round((($currentMonthProduction - $lastMonthProduction) / $lastMonthProduction) * 100, 1) : 0;
        
        $cycleTimeTrend = -8.2; // This could be calculated from historical data
        
        return view('manufacturer.analytics', [
            'title' => 'Manufacturer Analytics',
            'activePage' => 'analytics',
            'activeButton' => 'manufacturer',
            'navName' => 'Manufacturer Analytics',
            'analytics' => [
                'kpis' => [
                    'efficiency' => $efficiency,
                    'totalProduction' => $totalProduction,
                    'avgCycleTime' => $avgCycleTime,
                    'revenue' => $revenueUGX,
                    'avgPricePerUnit' => $avgPricePerUnitUGX,
                    'totalBatches' => $totalBatches,
                    'completedBatches' => $completedBatches,
                    'inProgressBatches' => $inProgressBatches,
                    'totalInventoryValue' => $totalInventoryValue,
                    'lowStockItems' => $lowStockItems,
                    'inventoryUtilization' => $inventoryUtilization
                ],
                'monthlyProduction' => $monthlyProduction,
                'topProducts' => $topProducts,
                'recentAlerts' => $recentAlerts,
                'trends' => [
                    'production' => $productionTrend,
                    'cycleTime' => $cycleTimeTrend
                ]
            ]
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

    public function updateProductionBatch(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
            'estimated_completion' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $batch = ProductionBatch::where('manufacturer_id', auth()->id())
                ->whereIn('status', ['pending', 'in_progress'])
                ->findOrFail($id);

            $batch->update([
                'quantity' => $request->quantity,
                'estimated_completion' => $request->estimated_completion,
                'notes' => $request->notes,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Batch updated successfully',
                    'batch' => $batch->load('product')
                ]);
            }

            return redirect()->back()->with('success', 'Batch updated successfully');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update batch: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to update batch');
        }
    }

    // Add this method to handle AJAX inventory creation
    public function storeInventory(Request $request)
    {
        // Log the request data for debugging
        \Log::info('Inventory creation request', [
            'data' => $request->all(),
            'user_id' => auth()->id(),
            'user_role' => auth()->user()->role ?? 'not set',
            'has_ajax' => $request->ajax(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);

        // Check if user is authenticated and has correct role
        if (!auth()->check()) {
            \Log::error('User not authenticated for inventory creation');
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'manufacturer') {
            \Log::error('User does not have manufacturer role', [
                'user_id' => auth()->id(),
                'user_role' => auth()->user()->role
            ]);
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized action');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'current_stock' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            // Check if inventory already exists for this product
            $existingInventory = Inventory::where('manufacturer_id', auth()->id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($existingInventory) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Inventory already exists for this product. Please update the existing inventory instead.'
                    ], 400);
                }
                return redirect()->back()->with('error', 'Inventory already exists for this product. Please update the existing inventory instead.');
            }

            $inventory = Inventory::create([
                'manufacturer_id' => auth()->id(),
                'product_id' => $request->product_id,
                'current_stock' => $request->current_stock,
                'minimum_stock' => $request->minimum_stock,
                'unit' => $request->unit,
                'quantity' => $request->current_stock,
                'notes' => $request->notes,
            ]);

            // Log successful creation
            \Log::info('Inventory created successfully', [
                'inventory_id' => $inventory->id,
                'user_id' => auth()->id()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Inventory created successfully',
                    'inventory' => $inventory->load('product'),
                    'redirect' => route('manufacturer.inventory.index')
                ]);
            }

            return redirect()->back()->with('success', 'Inventory created successfully');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to create inventory', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create inventory: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to create inventory');
        }
    }

    // ===== ORDER MANAGEMENT METHODS =====

    public function orders()
    {
        $orders = \App\Models\Order::with(['retailer', 'products', 'deliverySchedule'])
            ->latest()
            ->paginate(10);

        $drivers = \App\Models\User::where('role', 'driver')->get();
        $vehicles = \App\Models\Vehicle::all();

        return view('manufacturer.orders.index', [
            'orders' => $orders,
            'drivers' => $drivers,
            'vehicles' => $vehicles,
            'title' => 'Order Management',
            'activePage' => 'orders',
            'activeButton' => 'manufacturer',
            'navName' => 'Order Management'
        ]);
    }

    public function processOrder(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $order = \App\Models\Order::findOrFail($id);
            
            // Update order status
            $order->update([
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            // Update delivery schedule if exists
            if ($order->deliverySchedule) {
                $deliveryStatus = 'scheduled';
                
                switch ($request->status) {
                    case 'processing':
                        $deliveryStatus = 'scheduled';
                        break;
                    case 'shipped':
                        $deliveryStatus = 'in_transit';
                        break;
                    case 'delivered':
                        $deliveryStatus = 'delivered';
                        $order->deliverySchedule->update(['completed_at' => now()]);
                        break;
                    case 'cancelled':
                        $deliveryStatus = 'failed';
                        break;
                }

                $order->deliverySchedule->update(['status' => $deliveryStatus]);
            }

            // Create notification for retailer
            \App\Models\Notification::create([
                'user_id' => $order->retailer_id,
                'title' => 'Order Status Updated',
                'message' => "Your order #{$order->id} status has been updated to " . ucfirst($request->status),
                'type' => 'info',
                'data' => json_encode(['order_id' => $order->id, 'status' => $request->status]),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order' => $order->load(['retailer', 'products', 'deliverySchedule'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function assignDelivery(Request $request, $id)
    {
        $request->validate([
            'driver_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'delivery_notes' => 'nullable|string|max:500',
        ]);

        try {
            $order = \App\Models\Order::with('deliverySchedule')->findOrFail($id);
            
            if (!$order->deliverySchedule) {
                return response()->json([
                    'success' => false,
                    'message' => 'No delivery schedule found for this order'
                ], 400);
            }

            // Update delivery schedule
            $order->deliverySchedule->update([
                'driver_id' => $request->driver_id,
                'vehicle_id' => $request->vehicle_id,
                'notes' => $request->delivery_notes,
                'status' => 'assigned',
            ]);

            // Create notification for driver
            \App\Models\Notification::create([
                'user_id' => $request->driver_id,
                'title' => 'New Delivery Assignment',
                'message' => "You have been assigned to deliver order #{$order->id}",
                'type' => 'info',
                'data' => json_encode(['order_id' => $order->id, 'delivery_date' => $order->delivery_date]),
            ]);

            // Create notification for retailer
            \App\Models\Notification::create([
                'user_id' => $order->retailer_id,
                'title' => 'Delivery Assigned',
                'message' => "A driver has been assigned to your order #{$order->id}",
                'type' => 'success',
                'data' => json_encode(['order_id' => $order->id]),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery assigned successfully',
                'delivery' => $order->deliverySchedule->load(['driver', 'vehicle'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to assign delivery: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateDeliveryStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:scheduled,assigned,in_transit,delivered,failed',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $deliverySchedule = \App\Models\DeliverySchedule::with('order')->findOrFail($id);
            
            $deliverySchedule->update([
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            // Update order status based on delivery status
            $orderStatus = 'pending';
            switch ($request->status) {
                case 'in_transit':
                    $orderStatus = 'shipped';
                    break;
                case 'delivered':
                    $orderStatus = 'delivered';
                    $deliverySchedule->update(['completed_at' => now()]);
                    break;
                case 'failed':
                    $orderStatus = 'cancelled';
                    break;
            }

            if ($orderStatus !== 'pending') {
                $deliverySchedule->order->update(['status' => $orderStatus]);
            }

            // Create notification for retailer
            \App\Models\Notification::create([
                'user_id' => $deliverySchedule->order->retailer_id,
                'title' => 'Delivery Status Updated',
                'message' => "Your order #{$deliverySchedule->order->id} delivery status: " . ucfirst($request->status),
                'type' => 'info',
                'data' => json_encode(['order_id' => $deliverySchedule->order->id, 'status' => $request->status]),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery status updated successfully',
                'delivery' => $deliverySchedule->load(['order', 'driver', 'vehicle'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update delivery status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function orderDetails($id)
    {
        try {
            $order = \App\Models\Order::with(['retailer', 'products', 'deliverySchedule.driver', 'deliverySchedule.vehicle'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load order details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function inventoryReport()
    {
        try {
            $manufacturerId = auth()->id();
            
            // Get all inventory items for the manufacturer
            $inventory = Inventory::where('manufacturer_id', $manufacturerId)
                ->with('product')
                ->get();
            
            // Calculate comprehensive statistics
            $stats = [
                'total_items' => $inventory->count(),
                'total_stock' => $inventory->sum('current_stock'),
                'total_value' => $inventory->sum('current_stock'), // Simplified value calculation
                'low_stock_items' => $inventory->where('current_stock', '<=', 'minimum_stock')->count(),
                'out_of_stock_items' => $inventory->where('current_stock', 0)->count(),
                'well_stocked_items' => $inventory->where('current_stock', '>', 'minimum_stock')->count(),
                'average_stock_level' => $inventory->count() > 0 ? round($inventory->avg('current_stock'), 2) : 0,
                'stock_utilization' => $inventory->count() > 0 ? round(($inventory->where('current_stock', '>', 'minimum_stock')->count() / $inventory->count()) * 100, 1) : 0,
            ];
            
            // Calculate stock levels by category with proper filtering
            $stockLevels = [
                'critical' => $inventory->filter(function($item) {
                    return $item->current_stock < $item->minimum_stock;
                })->count(),
                'low' => $inventory->filter(function($item) {
                    return $item->current_stock >= $item->minimum_stock && $item->current_stock <= ($item->minimum_stock * 1.5);
                })->count(),
                'moderate' => $inventory->filter(function($item) {
                    return $item->current_stock > ($item->minimum_stock * 1.5) && $item->current_stock <= ($item->minimum_stock * 3);
                })->count(),
                'good' => $inventory->filter(function($item) {
                    return $item->current_stock > ($item->minimum_stock * 3);
                })->count(),
            ];
            
            // Get top products by stock level
            $topProducts = $inventory->sortByDesc('current_stock')->take(5);
            
            // Get low stock items that need attention
            $lowStockItems = $inventory->filter(function($item) {
                return $item->current_stock <= $item->minimum_stock;
            })->sortBy('current_stock');
            
            // Calculate stock turnover metrics (simplified)
            $stockTurnover = [];
            foreach ($inventory as $item) {
                $turnoverRate = $item->minimum_stock > 0 ? round(($item->current_stock / $item->minimum_stock), 2) : 0;
                $stockTurnover[] = [
                    'product' => $item->product->name ?? 'Unknown Product',
                    'current_stock' => $item->current_stock,
                    'minimum_stock' => $item->minimum_stock,
                    'unit' => $item->unit ?? 'units',
                    'turnover_rate' => $turnoverRate,
                    'status' => $turnoverRate < 1 ? 'Critical' : ($turnoverRate < 1.5 ? 'Low' : ($turnoverRate < 3 ? 'Moderate' : 'Good'))
                ];
            }
            
            // Sort by turnover rate
            usort($stockTurnover, function($a, $b) {
                return $a['turnover_rate'] <=> $b['turnover_rate'];
            });
            
            // Get top 5 items by turnover rate
            $topTurnoverItems = array_slice($stockTurnover, 0, 5);
            
            // Calculate monthly trends (simplified)
            $monthlyTrends = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthlyTrends[$month->format('M Y')] = [
                    'total_stock' => $inventory->sum('current_stock'), // Simplified - in real app, you'd track historical data
                    'items_count' => $inventory->count(),
                    'low_stock_count' => $inventory->filter(function($item) {
                        return $item->current_stock <= $item->minimum_stock;
                    })->count(),
                ];
            }
            
            // Generate report HTML
            $reportHtml = $this->generateInventoryReportHtml($stats, $stockLevels, $topProducts, $lowStockItems, $monthlyTrends, $topTurnoverItems);
            
            return response()->json([
                'success' => true,
                'html' => $reportHtml,
                'stats' => $stats,
                'stockLevels' => $stockLevels
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Failed to generate inventory report', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate inventory report: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateInventoryReportHtml($stats, $stockLevels, $topProducts, $lowStockItems, $monthlyTrends, $topTurnoverItems)
    {
        $html = '<div class="inventory-report">';
        
        // Report Header
        $html .= '<div class="report-header mb-4">';
        $html .= '<h4 class="report-title"><i class="nc-icon nc-chart-bar-32"></i> Inventory Report</h4>';
        $html .= '<p class="report-meta">Generated on ' . now()->format('F d, Y \a\t g:i A') . '</p>';
        $html .= '</div>';
        
        // Key Statistics Cards
        $html .= '<div class="stats-summary mb-4">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="summary-card total">';
        $html .= '<div class="summary-icon">';
        $html .= '<i class="nc-icon nc-box-2"></i>';
        $html .= '</div>';
        $html .= '<div class="summary-content">';
        $html .= '<h4 class="summary-number">' . number_format($stats['total_items']) . '</h4>';
        $html .= '<p class="summary-label">Total Items</p>';
        $html .= '<span class="summary-subtitle">In inventory</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="summary-card success">';
        $html .= '<div class="summary-icon">';
        $html .= '<i class="nc-icon nc-check-2"></i>';
        $html .= '</div>';
        $html .= '<div class="summary-content">';
        $html .= '<h4 class="summary-number">' . number_format($stats['total_stock']) . '</h4>';
        $html .= '<p class="summary-label">Total Stock</p>';
        $html .= '<span class="summary-subtitle">Units available</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="summary-card warning">';
        $html .= '<div class="summary-icon">';
        $html .= '<i class="nc-icon nc-bell-55"></i>';
        $html .= '</div>';
        $html .= '<div class="summary-content">';
        $html .= '<h4 class="summary-number">' . number_format($stats['low_stock_items']) . '</h4>';
        $html .= '<p class="summary-label">Low Stock</p>';
        $html .= '<span class="summary-subtitle">Needs attention</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="summary-card critical">';
        $html .= '<div class="summary-icon">';
        $html .= '<i class="nc-icon nc-alert-circle-i"></i>';
        $html .= '</div>';
        $html .= '<div class="summary-content">';
        $html .= '<h4 class="summary-number">' . number_format($stats['out_of_stock_items']) . '</h4>';
        $html .= '<p class="summary-label">Out of Stock</p>';
        $html .= '<span class="summary-subtitle">Critical items</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Additional Statistics
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-md-4 mb-3">';
        $html .= '<div class="stat-card info">';
        $html .= '<div class="stat-icon">';
        $html .= '<i class="nc-icon nc-chart-bar-32"></i>';
        $html .= '</div>';
        $html .= '<div class="stat-content">';
        $html .= '<h5 class="stat-number">' . number_format($stats['average_stock_level'], 1) . '</h5>';
        $html .= '<p class="stat-label">Average Stock Level</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4 mb-3">';
        $html .= '<div class="stat-card primary">';
        $html .= '<div class="stat-icon">';
        $html .= '<i class="nc-icon nc-settings-gear-65"></i>';
        $html .= '</div>';
        $html .= '<div class="stat-content">';
        $html .= '<h5 class="stat-number">' . number_format($stats['stock_utilization'], 1) . '%</h5>';
        $html .= '<p class="stat-label">Stock Utilization</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-4 mb-3">';
        $html .= '<div class="stat-card success">';
        $html .= '<div class="stat-icon">';
        $html .= '<i class="nc-icon nc-check-2"></i>';
        $html .= '</div>';
        $html .= '<div class="stat-content">';
        $html .= '<h5 class="stat-number">' . number_format($stats['well_stocked_items']) . '</h5>';
        $html .= '<p class="stat-label">Well Stocked Items</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Stock Level Analysis
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-md-6 mb-4">';
        $html .= '<div class="content-card">';
        $html .= '<div class="card-header">';
        $html .= '<div class="header-content">';
        $html .= '<h4 class="card-title">Stock Level Distribution</h4>';
        $html .= '<p class="card-subtitle">Inventory status breakdown</p>';
        $html .= '</div>';
        $html .= '<div class="header-icon">';
        $html .= '<i class="nc-icon nc-chart-pie-35"></i>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        $html .= '<div class="stock-level-item mb-3">';
        $html .= '<div class="level-info">';
        $html .= '<span class="level-badge critical">Critical</span>';
        $html .= '<span class="level-description">Below minimum stock</span>';
        $html .= '</div>';
        $html .= '<span class="level-count">' . $stockLevels['critical'] . ' items</span>';
        $html .= '</div>';
        $html .= '<div class="stock-level-item mb-3">';
        $html .= '<div class="level-info">';
        $html .= '<span class="level-badge warning">Low</span>';
        $html .= '<span class="level-description">Min - 1.5x minimum</span>';
        $html .= '</div>';
        $html .= '<span class="level-count">' . $stockLevels['low'] . ' items</span>';
        $html .= '</div>';
        $html .= '<div class="stock-level-item mb-3">';
        $html .= '<div class="level-info">';
        $html .= '<span class="level-badge info">Moderate</span>';
        $html .= '<span class="level-description">1.5x - 3x minimum</span>';
        $html .= '</div>';
        $html .= '<span class="level-count">' . $stockLevels['moderate'] . ' items</span>';
        $html .= '</div>';
        $html .= '<div class="stock-level-item">';
        $html .= '<div class="level-info">';
        $html .= '<span class="level-badge success">Good</span>';
        $html .= '<span class="level-description">Above 3x minimum</span>';
        $html .= '</div>';
        $html .= '<span class="level-count">' . $stockLevels['good'] . ' items</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Top Products
        $html .= '<div class="col-md-6 mb-4">';
        $html .= '<div class="content-card">';
        $html .= '<div class="card-header">';
        $html .= '<div class="header-content">';
        $html .= '<h4 class="card-title">Top Products by Stock</h4>';
        $html .= '<p class="card-subtitle">Highest stock levels</p>';
        $html .= '</div>';
        $html .= '<div class="header-icon">';
        $html .= '<i class="nc-icon nc-box-2"></i>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        if ($topProducts->count() > 0) {
            foreach ($topProducts as $item) {
                $html .= '<div class="product-item mb-3">';
                $html .= '<div class="product-info">';
                $html .= '<h6 class="product-name">' . ($item->product->name ?? 'Unknown Product') . '</h6>';
                $html .= '<span class="product-stock">' . number_format($item->current_stock) . ' units</span>';
                $html .= '</div>';
                $html .= '<div class="product-status">';
                $html .= '<span class="status-badge success">Well Stocked</span>';
                $html .= '</div>';
                $html .= '</div>';
            }
        } else {
            $html .= '<div class="empty-state">';
            $html .= '<p class="text-muted">No products found</p>';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Stock Turnover Analysis
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-12">';
        $html .= '<div class="content-card">';
        $html .= '<div class="card-header">';
        $html .= '<div class="header-content">';
        $html .= '<h4 class="card-title">Stock Turnover Analysis</h4>';
        $html .= '<p class="card-subtitle">Product turnover rates and efficiency</p>';
        $html .= '</div>';
        $html .= '<div class="header-icon">';
        $html .= '<i class="nc-icon nc-chart-bar-32"></i>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        if (!empty($topTurnoverItems)) {
            $html .= '<div class="table-responsive">';
            $html .= '<table class="table">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>Product</th>';
            $html .= '<th>Current Stock</th>';
            $html .= '<th>Minimum Stock</th>';
            $html .= '<th>Turnover Rate</th>';
            $html .= '<th>Status</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach ($topTurnoverItems as $item) {
                $statusClass = $item['status'] === 'Critical' ? 'danger' : ($item['status'] === 'Low' ? 'warning' : ($item['status'] === 'Moderate' ? 'info' : 'success'));
                $html .= '<tr>';
                $html .= '<td>' . $item['product'] . '</td>';
                $html .= '<td>' . number_format($item['current_stock']) . '</td>';
                $html .= '<td>' . number_format($item['minimum_stock']) . '</td>';
                $html .= '<td>' . number_format($item['turnover_rate'], 2) . '</td>';
                $html .= '<td><span class="status-badge ' . $statusClass . '">' . $item['status'] . '</span></td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
        } else {
            $html .= '<div class="empty-state">';
            $html .= '<p class="text-muted">No turnover data available</p>';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Monthly Trends
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-12">';
        $html .= '<div class="content-card">';
        $html .= '<div class="card-header">';
        $html .= '<div class="header-content">';
        $html .= '<h4 class="card-title">Monthly Trends</h4>';
        $html .= '<p class="card-subtitle">6-month inventory trends</p>';
        $html .= '</div>';
        $html .= '<div class="header-icon">';
        $html .= '<i class="nc-icon nc-chart-line-1"></i>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        $html .= '<div class="trends-grid">';
        foreach ($monthlyTrends as $month => $data) {
            $html .= '<div class="trend-item">';
            $html .= '<div class="trend-header">';
            $html .= '<h6 class="trend-month">' . $month . '</h6>';
            $html .= '</div>';
            $html .= '<div class="trend-stats">';
            $html .= '<div class="trend-stat">';
            $html .= '<span class="trend-value">' . number_format($data['total_stock']) . '</span>';
            $html .= '<span class="trend-label">Total Stock</span>';
            $html .= '</div>';
            $html .= '<div class="trend-stat">';
            $html .= '<span class="trend-value">' . number_format($data['items_count']) . '</span>';
            $html .= '<span class="trend-label">Items</span>';
            $html .= '</div>';
            $html .= '<div class="trend-stat">';
            $html .= '<span class="trend-value">' . number_format($data['low_stock_count']) . '</span>';
            $html .= '<span class="trend-label">Low Stock</span>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Quick Actions
        $html .= '<div class="quick-actions-section">';
        $html .= '<div class="section-header">';
        $html .= '<h5 class="section-title">';
        $html .= '<i class="nc-icon nc-settings-gear-65"></i>';
        $html .= 'Quick Actions';
        $html .= '</h5>';
        $html .= '</div>';
        $html .= '<div class="actions-grid">';
        $html .= '<button class="quick-action-btn" onclick="openStockAlertsModal()">';
        $html .= '<div class="action-icon">';
        $html .= '<i class="nc-icon nc-bell-55"></i>';
        $html .= '</div>';
        $html .= '<div class="action-content">';
        $html .= '<span class="action-title">View Stock Alerts</span>';
        $html .= '<span class="action-subtitle">Check critical alerts</span>';
        $html .= '</div>';
        $html .= '</button>';
        $html .= '<button class="quick-action-btn" onclick="openBulkUpdateModal()">';
        $html .= '<div class="action-icon">';
        $html .= '<i class="nc-icon nc-settings-gear-65"></i>';
        $html .= '</div>';
        $html .= '<div class="action-content">';
        $html .= '<span class="action-title">Bulk Update</span>';
        $html .= '<span class="action-subtitle">Update multiple items</span>';
        $html .= '</div>';
        $html .= '</button>';
        $html .= '<button class="quick-action-btn" onclick="downloadInventoryTemplate()">';
        $html .= '<div class="action-icon">';
        $html .= '<i class="nc-icon nc-cloud-download-93"></i>';
        $html .= '</div>';
        $html .= '<div class="action-content">';
        $html .= '<span class="action-title">Download Template</span>';
        $html .= '<span class="action-subtitle">Get CSV template</span>';
        $html .= '</div>';
        $html .= '</button>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>';
        
        // Add CSS styles
        $html .= '<style>';
        $html .= '.inventory-report { font-family: "Roboto", sans-serif; color: #2c3e50; }';
        $html .= '.report-header { text-align: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e9ecef; }';
        $html .= '.report-title { color: #2c3e50; font-size: 1.8rem; font-weight: 600; margin-bottom: 0.5rem; }';
        $html .= '.report-meta { color: #6c757d; font-size: 0.9rem; }';
        $html .= '.summary-card { background: rgba(255, 255, 255, 0.95); border-radius: 15px; padding: 1.5rem; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); transition: all 0.3s ease; height: 100%; display: flex; align-items: center; gap: 1rem; }';
        $html .= '.summary-card:hover { transform: translateY(-3px); box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15); }';
        $html .= '.summary-card.total { border-left: 4px solid #667eea; }';
        $html .= '.summary-card.success { border-left: 4px solid #28a745; }';
        $html .= '.summary-card.warning { border-left: 4px solid #ffc107; }';
        $html .= '.summary-card.critical { border-left: 4px solid #dc3545; }';
        $html .= '.summary-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: white; flex-shrink: 0; }';
        $html .= '.summary-card.total .summary-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }';
        $html .= '.summary-card.success .summary-icon { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }';
        $html .= '.summary-card.warning .summary-icon { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); }';
        $html .= '.summary-card.critical .summary-icon { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }';
        $html .= '.summary-content { flex: 1; }';
        $html .= '.summary-number { font-size: 2rem; font-weight: 700; margin: 0 0 0.25rem 0; color: #2c3e50; }';
        $html .= '.summary-label { font-size: 0.9rem; font-weight: 600; margin: 0 0 0.25rem 0; color: #495057; }';
        $html .= '.summary-subtitle { font-size: 0.75rem; color: #6c757d; }';
        $html .= '.stat-card { background: rgba(255, 255, 255, 0.95); border-radius: 15px; padding: 1.5rem; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); transition: all 0.3s ease; height: 100%; display: flex; align-items: center; gap: 1rem; }';
        $html .= '.stat-card:hover { transform: translateY(-2px); box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15); }';
        $html .= '.stat-icon { width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: white; flex-shrink: 0; }';
        $html .= '.stat-card.info .stat-icon { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }';
        $html .= '.stat-card.primary .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }';
        $html .= '.stat-card.success .stat-icon { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }';
        $html .= '.stat-content { flex: 1; }';
        $html .= '.stat-number { font-size: 1.5rem; font-weight: 700; margin: 0 0 0.25rem 0; color: #2c3e50; }';
        $html .= '.stat-label { font-size: 0.85rem; color: #6c757d; margin: 0; }';
        $html .= '.content-card { background: rgba(255, 255, 255, 0.95); border-radius: 15px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); overflow: hidden; margin-bottom: 1.5rem; }';
        $html .= '.card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; }';
        $html .= '.header-content h4 { margin: 0; font-size: 1.2rem; font-weight: 600; }';
        $html .= '.header-content p { margin: 5px 0 0 0; opacity: 0.9; font-size: 0.9rem; }';
        $html .= '.header-icon { width: 40px; height: 40px; background: rgba(255, 255, 255, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; }';
        $html .= '.card-body { padding: 1.5rem; }';
        $html .= '.stock-level-item { display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8f9fa; border-radius: 8px; margin-bottom: 0.75rem; }';
        $html .= '.level-info { display: flex; flex-direction: column; }';
        $html .= '.level-badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }';
        $html .= '.level-badge.critical { background: rgba(220, 53, 69, 0.1); color: #dc3545; }';
        $html .= '.level-badge.warning { background: rgba(255, 193, 7, 0.1); color: #e0a800; }';
        $html .= '.level-badge.info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }';
        $html .= '.level-badge.success { background: rgba(40, 167, 69, 0.1); color: #28a745; }';
        $html .= '.level-description { font-size: 0.8rem; color: #6c757d; margin-top: 0.25rem; }';
        $html .= '.level-count { font-weight: 600; color: #2c3e50; }';
        $html .= '.product-item { display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #f8f9fa; border-radius: 8px; margin-bottom: 0.75rem; }';
        $html .= '.product-info { display: flex; flex-direction: column; }';
        $html .= '.product-name { font-weight: 600; color: #2c3e50; margin: 0 0 0.25rem 0; }';
        $html .= '.product-stock { font-size: 0.85rem; color: #6c757d; }';
        $html .= '.status-badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }';
        $html .= '.status-badge.success { background: rgba(40, 167, 69, 0.1); color: #28a745; }';
        $html .= '.status-badge.warning { background: rgba(255, 193, 7, 0.1); color: #e0a800; }';
        $html .= '.status-badge.info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }';
        $html .= '.status-badge.danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; }';
        $html .= '.trends-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; }';
        $html .= '.trend-item { background: #f8f9fa; border-radius: 8px; padding: 1rem; text-align: center; }';
        $html .= '.trend-month { font-weight: 600; color: #2c3e50; margin-bottom: 1rem; }';
        $html .= '.trend-stats { display: flex; flex-direction: column; gap: 0.5rem; }';
        $html .= '.trend-stat { display: flex; flex-direction: column; }';
        $html .= '.trend-value { font-size: 1.1rem; font-weight: 700; color: #2c3e50; }';
        $html .= '.trend-label { font-size: 0.8rem; color: #6c757d; }';
        $html .= '.quick-actions-section { margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(0, 0, 0, 0.1); }';
        $html .= '.section-header { display: flex; align-items: center; margin-bottom: 1rem; }';
        $html .= '.section-title { font-size: 1.1rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem; color: #2c3e50; }';
        $html .= '.actions-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; }';
        $html .= '.quick-action-btn { background: rgba(255, 255, 255, 0.9); border: 1px solid rgba(0, 0, 0, 0.05); border-radius: 12px; padding: 1.5rem; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit; }';
        $html .= '.quick-action-btn:hover { background: rgba(255, 255, 255, 0.95); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); text-decoration: none; color: inherit; }';
        $html .= '.action-icon { width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; flex-shrink: 0; }';
        $html .= '.action-content { flex: 1; }';
        $html .= '.action-title { display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.25rem; }';
        $html .= '.action-subtitle { display: block; font-size: 0.8rem; color: #6c757d; }';
        $html .= '.empty-state { text-align: center; padding: 2rem; color: #6c757d; }';
        $html .= '@media (max-width: 768px) { .trends-grid { grid-template-columns: 1fr; } .actions-grid { grid-template-columns: 1fr; } }';
        $html .= '</style>';
        
        return $html;
    }

    public function stockAlerts()
    {
        // Get low stock items
        $lowStockItems = Inventory::where('quantity', '<=', 50)
            ->with('product')
            ->get();

        // Generate HTML for stock alerts
        $html = view('manufacturer.reports.stock-alerts', compact('lowStockItems'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function efficiencyReport()
    {
        $manufacturerId = auth()->id();
        
        // Calculate production efficiency metrics
        $totalBatches = ProductionBatch::where('manufacturer_id', $manufacturerId)->count();
        $completedBatches = ProductionBatch::where('manufacturer_id', $manufacturerId)->where('status', 'completed')->count();
        $efficiencyRate = $totalBatches > 0 ? ($completedBatches / $totalBatches) * 100 : 0;

        // Calculate average production time
        $avgProductionTime = ProductionBatch::where('manufacturer_id', $manufacturerId)
            ->where('status', 'completed')
            ->whereNotNull('start_date')
            ->whereNotNull('completed_at')
            ->get()
            ->avg(function($batch) {
                return \Carbon\Carbon::parse($batch->start_date)->diffInHours($batch->completed_at);
            });

        // Get monthly production trends
        $monthlyProduction = ProductionBatch::where('manufacturer_id', $manufacturerId)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate resource utilization (more realistic calculation)
        $totalProductionCapacity = 10000; // Monthly capacity in units
        $totalProduced = ProductionBatch::where('manufacturer_id', $manufacturerId)
            ->where('status', 'completed')
            ->sum('quantity');
        $utilizationRate = $totalProductionCapacity > 0 ? ($totalProduced / $totalProductionCapacity) * 100 : 0;

        // Get status breakdown
        $statusBreakdown = ProductionBatch::where('manufacturer_id', $manufacturerId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Get recent activity
        $recentActivity = ProductionBatch::where('manufacturer_id', $manufacturerId)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $reportHtml = view('manufacturer.reports.efficiency', compact(
            'efficiencyRate',
            'avgProductionTime',
            'monthlyProduction',
            'utilizationRate',
            'totalBatches',
            'completedBatches',
            'statusBreakdown',
            'recentActivity',
            'totalProduced'
        ))->render();

        return response()->json([
            'success' => true,
            'html' => $reportHtml
        ]);
    }

    public function financialReport()
    {
        // Calculate revenue from orders
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // Calculate costs
        $totalCosts = PurchaseOrder::where('status', 'completed')->sum('total_amount');
        
        // Calculate profit
        $totalProfit = $totalRevenue - $totalCosts;
        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        // Monthly revenue trends
        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->where('status', 'completed')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top selling products
        $topProducts = Order::join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->selectRaw('products.name, SUM(order_product.quantity) as total_sold, SUM(order_product.quantity * order_product.price) as revenue')
            ->where('orders.status', 'completed')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Calculate average order value
        $avgOrderValue = Order::where('status', 'completed')->avg('total_amount');

        $reportHtml = view('manufacturer.reports.financial', compact(
            'totalRevenue',
            'totalCosts',
            'totalProfit',
            'profitMargin',
            'monthlyRevenue',
            'topProducts',
            'avgOrderValue'
        ))->render();

        return response()->json([
            'success' => true,
            'html' => $reportHtml
        ]);
    }

    public function bulkUpdateInventory(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        try {
            $file = $request->file('csv_file');
            $path = $file->getRealPath();
            
            $results = [
                'success' => 0,
                'failed' => 0,
                'errors' => [],
                'updated_items' => []
            ];

            // Read CSV file
            if (($handle = fopen($path, "r")) !== FALSE) {
                $header = fgetcsv($handle); // Skip header row
                
                // Validate header
                if (!$header || count($header) < 3) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid CSV format. Expected columns: Product Name, Current Stock, Minimum Stock, Notes (Optional)'
                    ], 400);
                }
                
                $rowNumber = 1; // Start from 1 since we skipped header
                
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $rowNumber++;
                    
                    if (count($data) < 3) {
                        $results['failed']++;
                        $results['errors'][] = "Row {$rowNumber}: Insufficient data (expected at least 3 columns)";
                        continue;
                    }

                    $productName = trim($data[0]);
                    $currentStock = trim($data[1]);
                    $minimumStock = trim($data[2]);
                    $notes = isset($data[3]) ? trim($data[3]) : '';

                    // Validate data
                    if (empty($productName)) {
                        $results['failed']++;
                        $results['errors'][] = "Row {$rowNumber}: Product name is required";
                        continue;
                    }
                    
                    if (!is_numeric($currentStock) || $currentStock < 0) {
                        $results['failed']++;
                        $results['errors'][] = "Row {$rowNumber}: Current stock must be a positive number";
                        continue;
                    }
                    
                    if (!is_numeric($minimumStock) || $minimumStock < 0) {
                        $results['failed']++;
                        $results['errors'][] = "Row {$rowNumber}: Minimum stock must be a positive number";
                        continue;
                    }

                    // Find inventory by product name (case-insensitive search)
                    $inventory = Inventory::where('manufacturer_id', auth()->id())
                        ->whereHas('product', function($query) use ($productName) {
                            $query->where('name', 'like', '%' . $productName . '%');
                        })
                        ->first();

                    if (!$inventory) {
                        $results['failed']++;
                        $results['errors'][] = "Row {$rowNumber}: Product '{$productName}' not found in inventory";
                        continue;
                    }

                    // Store original values for comparison
                    $originalStock = $inventory->current_stock;
                    $originalMinStock = $inventory->minimum_stock;

                    // Update inventory
                    $inventory->update([
                        'current_stock' => (int)$currentStock,
                        'minimum_stock' => (int)$minimumStock,
                        'quantity' => (int)$currentStock,
                        'notes' => $notes ?: $inventory->notes,
                    ]);

                    $results['success']++;
                    $results['updated_items'][] = [
                        'product_name' => $inventory->product->name,
                        'old_stock' => $originalStock,
                        'new_stock' => (int)$currentStock,
                        'old_min_stock' => $originalMinStock,
                        'new_min_stock' => (int)$minimumStock,
                    ];
                }
                fclose($handle);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to read CSV file'
                ], 500);
            }

            // Log the bulk update operation
            \Log::info('Bulk inventory update completed', [
                'user_id' => auth()->id(),
                'success_count' => $results['success'],
                'failed_count' => $results['failed'],
                'total_processed' => $results['success'] + $results['failed']
            ]);

            return response()->json([
                'success' => true,
                'message' => "Bulk update completed. {$results['success']} items updated successfully, {$results['failed']} failed.",
                'results' => $results
            ]);

        } catch (\Exception $e) {
            \Log::error('Bulk inventory update failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process bulk update: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadInventoryTemplate()
    {
        $inventory = Inventory::where('manufacturer_id', auth()->id())
            ->with('product')
            ->get();

        $filename = 'inventory_bulk_update_template_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($inventory) {
            $file = fopen('php://output', 'w');
            
            // Add header row
            fputcsv($file, ['Product Name', 'Current Stock', 'Minimum Stock', 'Notes (Optional)']);
            
            // Add data rows with current values
            foreach ($inventory as $item) {
                fputcsv($file, [
                    $item->product->name ?? 'Unknown Product',
                    $item->current_stock,
                    $item->minimum_stock,
                    $item->notes ?? ''
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function productionReport()
    {
        try {
            $manufacturerId = auth()->id();
            
            // Get production data
            $productionBatches = ProductionBatch::where('manufacturer_id', $manufacturerId)
                ->with('product')
                ->get();
            
            // Calculate production statistics
            $totalBatches = $productionBatches->count();
            $completedBatches = $productionBatches->where('status', 'completed')->count();
            $inProgressBatches = $productionBatches->where('status', 'in_progress')->count();
            $pendingBatches = $productionBatches->where('status', 'pending')->count();
            
            $totalProduction = $productionBatches->where('status', 'completed')->sum('quantity');
            $totalRevenue = $totalProduction * 5000; // Assuming 5000 UGX per unit
            
            // Calculate efficiency metrics
            $efficiency = $totalBatches > 0 ? round(($completedBatches / $totalBatches) * 100, 1) : 0;
            
            // Calculate average cycle time
            $avgCycleTime = 0;
            $completedBatchesData = $productionBatches->where('status', 'completed');
            if ($completedBatchesData->count() > 0) {
                $totalHours = 0;
                $validBatches = 0;
                foreach ($completedBatchesData as $batch) {
                    if ($batch->start_date && $batch->estimated_completion) {
                        try {
                            $start = \Carbon\Carbon::parse($batch->start_date);
                            $end = \Carbon\Carbon::parse($batch->estimated_completion);
                            if ($start->lt($end)) {
                                $totalHours += $start->diffInHours($end);
                                $validBatches++;
                            }
                        } catch (\Exception $e) {
                            \Log::warning('Invalid date format in production batch', [
                                'batch_id' => $batch->id,
                                'start_date' => $batch->start_date,
                                'estimated_completion' => $batch->estimated_completion
                            ]);
                        }
                    }
                }
                $avgCycleTime = $validBatches > 0 ? round($totalHours / $validBatches, 1) : 0;
            }
            
            // Monthly production trends
            $monthlyProduction = [];
            for ($i = 3; $i >= 0; $i--) {
                $month = now()->subMonths($i)->format('M Y');
                $monthStart = now()->subMonths($i)->startOfMonth();
                $monthEnd = now()->subMonths($i)->endOfMonth();
                
                $monthlyProduction[$month] = $productionBatches
                    ->where('status', 'completed')
                    ->filter(function ($batch) use ($monthStart, $monthEnd) {
                        if (!$batch->start_date) return false;
                        try {
                            return \Carbon\Carbon::parse($batch->start_date)->between($monthStart, $monthEnd);
                        } catch (\Exception $e) {
                            return false;
                        }
                    })
                    ->sum('quantity');
            }
            
            // Top performing products
            $topProducts = $productionBatches
                ->where('status', 'completed')
                ->groupBy('product_id')
                ->map(function ($batches) {
                    return [
                        'product' => $batches->first()->product,
                        'total_quantity' => $batches->sum('quantity'),
                        'batch_count' => $batches->count()
                    ];
                })
                ->sortByDesc('total_quantity')
                ->take(5);
            
            // Production status breakdown
            $statusBreakdown = [
                'completed' => $completedBatches,
                'in_progress' => $inProgressBatches,
                'pending' => $pendingBatches
            ];
            
            // Recent production activity
            $recentActivity = $productionBatches
                ->sortByDesc('created_at')
                ->take(10)
                ->map(function ($batch) {
                    return [
                        'id' => $batch->id,
                        'product_name' => $batch->product->name ?? 'Unknown Product',
                        'quantity' => $batch->quantity,
                        'status' => $batch->status,
                        'start_date' => $batch->start_date,
                        'estimated_completion' => $batch->estimated_completion,
                        'created_at' => $batch->created_at
                    ];
                });
            
            // Log successful report generation
            \Log::info('Production report generated successfully', [
                'user_id' => $manufacturerId,
                'total_batches' => $totalBatches,
                'completed_batches' => $completedBatches,
                'total_production' => $totalProduction
            ]);
            
            // Generate HTML report
            $html = $this->generateProductionReportHtml(
                $totalBatches,
                $completedBatches,
                $inProgressBatches,
                $pendingBatches,
                $totalProduction,
                $totalRevenue,
                $efficiency,
                $avgCycleTime,
                $monthlyProduction,
                $topProducts,
                $statusBreakdown,
                $recentActivity
            );
            
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Production report generation failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate production report: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateProductionReportHtml($totalBatches, $completedBatches, $inProgressBatches, $pendingBatches, $totalProduction, $totalRevenue, $efficiency, $avgCycleTime, $monthlyProduction, $topProducts, $statusBreakdown, $recentActivity)
    {
        $html = '<div class="production-report">';
        
        // Header
        $html .= '<div class="report-header mb-4">';
        $html .= '<h4 class="text-primary mb-2"><i class="nc-icon nc-chart-bar-32"></i> Production Report</h4>';
        $html .= '<p class="text-muted mb-0">Comprehensive analysis of manufacturing performance and production metrics</p>';
        $html .= '<div class="report-meta mt-2">';
        $html .= '<small class="text-muted">Generated on: ' . now()->format('F j, Y \a\t g:i A') . '</small>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Key Metrics Section
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="metric-card bg-primary text-white p-3 rounded">';
        $html .= '<h5 class="mb-1">' . number_format($totalBatches) . '</h5>';
        $html .= '<small>Total Batches</small>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="metric-card bg-success text-white p-3 rounded">';
        $html .= '<h5 class="mb-1">' . number_format($totalProduction) . '</h5>';
        $html .= '<small>Units Produced</small>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="metric-card bg-info text-white p-3 rounded">';
        $html .= '<h5 class="mb-1">' . $efficiency . '%</h5>';
        $html .= '<small>Efficiency Rate</small>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-md-3 mb-3">';
        $html .= '<div class="metric-card bg-warning text-white p-3 rounded">';
        $html .= '<h5 class="mb-1">' . number_format($totalRevenue) . '</h5>';
        $html .= '<small>Revenue (UGX)</small>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Production Status Breakdown
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-md-6">';
        $html .= '<div class="card">';
        $html .= '<div class="card-header">';
        $html .= '<h6 class="mb-0"><i class="nc-icon nc-pie-chart"></i> Production Status Breakdown</h6>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        $html .= '<div class="status-breakdown">';
        $html .= '<div class="status-item d-flex justify-content-between align-items-center mb-2">';
        $html .= '<span><i class="nc-icon nc-check-2 text-success"></i> Completed</span>';
        $html .= '<span class="badge badge-success">' . $completedBatches . '</span>';
        $html .= '</div>';
        $html .= '<div class="status-item d-flex justify-content-between align-items-center mb-2">';
        $html .= '<span><i class="nc-icon nc-settings-gear-65 text-info"></i> In Progress</span>';
        $html .= '<span class="badge badge-info">' . $inProgressBatches . '</span>';
        $html .= '</div>';
        $html .= '<div class="status-item d-flex justify-content-between align-items-center mb-2">';
        $html .= '<span><i class="nc-icon nc-time-alarm text-warning"></i> Pending</span>';
        $html .= '<span class="badge badge-warning">' . $pendingBatches . '</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Performance Metrics
        $html .= '<div class="col-md-6">';
        $html .= '<div class="card">';
        $html .= '<div class="card-header">';
        $html .= '<h6 class="mb-0"><i class="nc-icon nc-chart-bar-32"></i> Performance Metrics</h6>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        $html .= '<div class="performance-metrics">';
        $html .= '<div class="metric-item d-flex justify-content-between align-items-center mb-2">';
        $html .= '<span>Average Cycle Time</span>';
        $html .= '<span class="font-weight-bold">' . $avgCycleTime . ' hours</span>';
        $html .= '</div>';
        $html .= '<div class="metric-item d-flex justify-content-between align-items-center mb-2">';
        $html .= '<span>Completion Rate</span>';
        $html .= '<span class="font-weight-bold">' . $efficiency . '%</span>';
        $html .= '</div>';
        $html .= '<div class="metric-item d-flex justify-content-between align-items-center mb-2">';
        $html .= '<span>Average Batch Size</span>';
        $html .= '<span class="font-weight-bold">' . ($totalBatches > 0 ? number_format($totalProduction / $totalBatches) : 0) . ' units</span>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Monthly Production Trends
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-12">';
        $html .= '<div class="card">';
        $html .= '<div class="card-header">';
        $html .= '<h6 class="mb-0"><i class="nc-icon nc-chart-bar-32"></i> Monthly Production Trends</h6>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        $html .= '<div class="chart-container">';
        $html .= '<div class="chart-bars d-flex align-items-end justify-content-between" style="height: 200px;">';
        
        $maxProduction = max($monthlyProduction);
        foreach ($monthlyProduction as $month => $production) {
            $percentage = $maxProduction > 0 ? ($production / $maxProduction) * 100 : 0;
            $html .= '<div class="chart-bar-item text-center" style="flex: 1; margin: 0 5px;">';
            $html .= '<div class="bar-container" style="height: 100%; position: relative;">';
            $html .= '<div class="bar-fill bg-primary" style="height: ' . $percentage . '%; position: absolute; bottom: 0; width: 100%; border-radius: 4px 4px 0 0;"></div>';
            $html .= '</div>';
            $html .= '<div class="bar-label mt-2" style="font-size: 0.8rem;">' . $month . '</div>';
            $html .= '<div class="bar-value" style="font-size: 0.7rem; color: #6c757d;">' . number_format($production) . '</div>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Top Performing Products
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-md-6">';
        $html .= '<div class="card">';
        $html .= '<div class="card-header">';
        $html .= '<h6 class="mb-0"><i class="nc-icon nc-box-2"></i> Top Performing Products</h6>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        if ($topProducts->count() > 0) {
            $html .= '<div class="top-products">';
            foreach ($topProducts as $productData) {
                $html .= '<div class="product-item d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">';
                $html .= '<div>';
                $html .= '<div class="font-weight-bold">' . ($productData['product']->name ?? 'Unknown Product') . '</div>';
                $html .= '<small class="text-muted">' . $productData['batch_count'] . ' batches</small>';
                $html .= '</div>';
                $html .= '<div class="text-right">';
                $html .= '<div class="font-weight-bold">' . number_format($productData['total_quantity']) . '</div>';
                $html .= '<small class="text-muted">units</small>';
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
        } else {
            $html .= '<p class="text-muted text-center">No production data available</p>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Recent Production Activity
        $html .= '<div class="col-md-6">';
        $html .= '<div class="card">';
        $html .= '<div class="card-header">';
        $html .= '<h6 class="mb-0"><i class="nc-icon nc-time-alarm"></i> Recent Production Activity</h6>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        if ($recentActivity->count() > 0) {
            $html .= '<div class="recent-activity">';
            foreach ($recentActivity as $activity) {
                $statusClass = $activity['status'] === 'completed' ? 'success' : ($activity['status'] === 'in_progress' ? 'info' : 'warning');
                $statusIcon = $activity['status'] === 'completed' ? 'check-2' : ($activity['status'] === 'in_progress' ? 'settings-gear-65' : 'time-alarm');
                
                $html .= '<div class="activity-item d-flex align-items-start mb-2 p-2 border-bottom">';
                $html .= '<div class="activity-icon mr-2">';
                $html .= '<i class="nc-icon nc-' . $statusIcon . ' text-' . $statusClass . '"></i>';
                $html .= '</div>';
                $html .= '<div class="activity-content flex-grow-1">';
                $html .= '<div class="font-weight-bold">' . $activity['product_name'] . '</div>';
                $html .= '<small class="text-muted">Batch #' . $activity['id'] . ' • ' . number_format($activity['quantity']) . ' units</small>';
                $html .= '</div>';
                $html .= '<div class="activity-status">';
                $html .= '<span class="badge badge-' . $statusClass . '">' . ucfirst(str_replace('_', ' ', $activity['status'])) . '</span>';
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
        } else {
            $html .= '<p class="text-muted text-center">No recent activity</p>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Summary and Recommendations
        $html .= '<div class="row">';
        $html .= '<div class="col-12">';
        $html .= '<div class="card">';
        $html .= '<div class="card-header">';
        $html .= '<h6 class="mb-0"><i class="nc-icon nc-light-3"></i> Summary & Recommendations</h6>';
        $html .= '</div>';
        $html .= '<div class="card-body">';
        $html .= '<div class="summary-content">';
        
        // Summary
        $html .= '<div class="summary-section mb-3">';
        $html .= '<h6 class="text-primary">Production Summary</h6>';
        $html .= '<p class="mb-2">Your manufacturing operation has produced <strong>' . number_format($totalProduction) . ' units</strong> across <strong>' . $totalBatches . ' production batches</strong> with an efficiency rate of <strong>' . $efficiency . '%</strong>.</p>';
        $html .= '</div>';
        
        // Recommendations
        $html .= '<div class="recommendations-section">';
        $html .= '<h6 class="text-success">Recommendations</h6>';
        $html .= '<ul class="list-unstyled">';
        
        if ($efficiency < 80) {
            $html .= '<li class="mb-1"><i class="nc-icon nc-alert-circle-i text-warning"></i> Consider optimizing production processes to improve efficiency</li>';
        }
        
        if ($avgCycleTime > 48) {
            $html .= '<li class="mb-1"><i class="nc-icon nc-time-alarm text-info"></i> Review cycle times to identify bottlenecks</li>';
        }
        
        if ($pendingBatches > $completedBatches * 0.3) {
            $html .= '<li class="mb-1"><i class="nc-icon nc-settings-gear-65 text-primary"></i> Prioritize pending batches to maintain production flow</li>';
        }
        
        if ($topProducts->count() > 0) {
            $html .= '<li class="mb-1"><i class="nc-icon nc-chart-bar-32 text-success"></i> Focus on high-performing products for maximum output</li>';
        }
        
        $html .= '</ul>';
        $html .= '</div>';
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div>';
        
        return $html;
    }

    public function rawMaterialOrders()
    {
        $suppliers = \App\Models\User::where('role', 'supplier')->get();
        $rawMaterials = \App\Models\RawMaterial::with('supplier')
            ->where('status', 'available')
            ->get()
            ->groupBy('supplier_id');
        
        $myOrders = \App\Models\PurchaseOrder::where('manufacturer_id', auth()->id())
            ->with('supplier')
            ->latest()
            ->paginate(10);
        
        return view('manufacturer.raw-material-orders.index', [
            'suppliers' => $suppliers,
            'rawMaterials' => $rawMaterials,
            'myOrders' => $myOrders,
            'title' => 'Raw Material Orders',
            'activePage' => 'raw-material-orders',
            'activeButton' => 'manufacturer',
            'navName' => 'Raw Material Orders'
        ]);
    }

    public function storeRawMaterialOrder(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:users,id',
            'materials' => 'required|array|min:1',
            'materials.*.material_id' => 'required|exists:raw_materials,id',
            'materials.*.quantity' => 'required|numeric|min:1',
            'delivery_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            // Calculate total amount
            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->materials as $materialData) {
                $material = \App\Models\RawMaterial::find($materialData['material_id']);
                if (!$material || $material->supplier_id != $request->supplier_id) {
                    return redirect()->back()->with('error', 'Invalid material selected');
                }

                $itemTotal = $material->price * $materialData['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'material_id' => $materialData['material_id'],
                    'quantity' => $materialData['quantity'],
                    'unit_price' => $material->price,
                    'total_price' => $itemTotal,
                ];
            }

            // Generate order number
            $orderNumber = 'PO-' . date('Ymd') . '-' . str_pad(\App\Models\PurchaseOrder::count() + 1, 4, '0', STR_PAD_LEFT);
            
            // Create purchase order
            $purchaseOrder = \App\Models\PurchaseOrder::create([
                'manufacturer_id' => auth()->id(),
                'supplier_id' => $request->supplier_id,
                'order_number' => $orderNumber,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'expected_delivery_date' => $request->delivery_date,
                'notes' => $request->notes,
            ]);

            // Create purchase order items
            foreach ($orderItems as $item) {
                \App\Models\PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'raw_material_id' => $item['material_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                    'subtotal' => $item['total_price'], // Add subtotal field
                ]);
            }

            // Create notification for supplier
            \App\Models\Notification::create([
                'user_id' => $request->supplier_id,
                'title' => 'New Raw Material Order',
                'message' => 'You have received a new order for raw materials from ' . auth()->user()->name,
                'type' => 'order',
                'read' => false,
            ]);

            return redirect()->route('manufacturer.raw-material-orders')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function rawMaterialOrderDetails($id)
    {
        $order = \App\Models\PurchaseOrder::where('manufacturer_id', auth()->id())
            ->with(['supplier', 'items.rawMaterial'])
            ->findOrFail($id);

        return view('manufacturer.raw-material-orders.details', [
            'order' => $order,
            'title' => 'Order Details',
            'activePage' => 'raw-material-orders',
            'activeButton' => 'manufacturer',
            'navName' => 'Order Details'
        ]);
    }
} 