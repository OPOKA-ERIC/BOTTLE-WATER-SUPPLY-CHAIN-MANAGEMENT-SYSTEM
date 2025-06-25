<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\DeliverySchedule;
use App\Models\CustomerSegment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Calculate statistics
        $stats = [
            'total_orders' => Order::where('retailer_id', $user->id)->count(),
            'pending_orders' => Order::where('retailer_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'total_revenue' => Order::where('retailer_id', $user->id)
                ->where('status', 'completed')
                ->sum('total_amount')
        ];

        // Get recent orders
        $recentOrders = Order::where('retailer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming deliveries
        $upcomingDeliveries = DeliverySchedule::where('retailer_id', $user->id)
            ->where('delivery_date', '>=', now())
            ->take(5)
            ->get();

        // Get recommended products based on customer segment
        $recommendedProducts = collect();
        if ($user->customer_segment_id) {
            $recommendedProducts = Product::whereHas('customerSegments', function($query) use ($user) {
                $query->where('customer_segments.id', $user->customer_segment_id);
            })->take(4)->get();
        }

        return view('retailer.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'upcomingDeliveries' => $upcomingDeliveries,
            'recommendedProducts' => $recommendedProducts,
            'activeButton' => 'dashboard',
            'navName' => 'Retailer Dashboard'
        ]);
    }

    public function orders()
    {
        $orders = Order::where('retailer_id', auth()->id())
            ->with('products')
            ->latest()
            ->paginate(10);
        return view('retailer.orders.index', compact('orders'))
            ->with('title', 'Retailer Orders - BWSCMS')
            ->with('activePage', 'orders')
            ->with('navName', 'Retailer Orders');
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'delivery_address' => 'required|string',
            'delivery_date' => 'required|date|after:today',
        ]);

        $order = Order::create([
            'retailer_id' => auth()->id(),
            'delivery_address' => $request->delivery_address,
            'delivery_date' => $request->delivery_date,
            'status' => 'pending',
        ]);

        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => Product::find($product['id'])->price,
            ]);
        }

        DeliverySchedule::create([
            'order_id' => $order->id,
            'retailer_id' => auth()->id(),
            'delivery_date' => $request->delivery_date,
            'status' => 'scheduled',
        ]);

        return redirect()->route('retailer.orders.show', $order)
            ->with('success', 'Order placed successfully');
    }

    public function trackOrder($id)
    {
        $order = Order::where('retailer_id', auth()->id())
            ->with(['products', 'deliverySchedule'])
            ->findOrFail($id);

        return view('retailer.orders.track', compact('order'))
            ->with('title', 'Track Order - BWSCMS')
            ->with('activePage', 'orders')
            ->with('navName', 'Track Order');
    }

    public function reports()
    {
        $salesReport = Order::where('retailer_id', auth()->id())
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $productReport = Order::where('retailer_id', auth()->id())
            ->where('status', 'completed')
            ->with('products')
            ->get()
            ->pluck('products')
            ->flatten()
            ->groupBy('id')
            ->map(function ($products) {
                return [
                    'name' => $products->first()->name,
                    'total_quantity' => $products->sum('pivot.quantity'),
                    'total_revenue' => $products->sum(function ($product) {
                        return $product->pivot->quantity * $product->pivot->price;
                    }),
                ];
            });

        return view('retailer.reports.index', compact('salesReport', 'productReport'))
            ->with('title', 'Retailer Reports - BWSCMS')
            ->with('activePage', 'reports')
            ->with('navName', 'Retailer Reports');
    }
} 