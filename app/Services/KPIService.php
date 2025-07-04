<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Inventory;
use App\Models\User;
use App\Models\VendorApplication;
use App\Models\Task;
use App\Models\ProductionBatch;
use App\Models\PurchaseOrder;
use App\Models\RawMaterial;
use App\Models\DeliverySchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KPIService
{
    /**
     * Get Admin KPIs
     */
    public function getAdminKPIs()
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();
        
        return [
            // User Management KPIs
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'new_users_this_month' => User::where('created_at', '>=', $lastMonth)->count(),
            'user_growth_rate' => $this->calculateGrowthRate('users'),
            
            // Order Management KPIs
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'order_fulfillment_rate' => $this->calculateOrderFulfillmentRate(),
            'average_order_processing_time' => $this->calculateAverageOrderProcessingTime(),
            
            // Inventory KPIs
            'total_inventory_value' => Inventory::sum(DB::raw('quantity * unit_price')),
            'low_stock_items' => Inventory::where('quantity', '<=', DB::raw('reorder_level'))->count(),
            'inventory_turnover_rate' => $this->calculateInventoryTurnoverRate(),
            
            // Vendor Management KPIs
            'total_vendor_applications' => VendorApplication::count(),
            'pending_applications' => VendorApplication::where('status', 'pending')->count(),
            'approval_rate' => $this->calculateVendorApprovalRate(),
            
            // Task Management KPIs
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'overdue_tasks' => Task::overdue()->count(),
            'task_completion_rate' => $this->calculateTaskCompletionRate(),
            'average_task_completion_time' => $this->calculateAverageTaskCompletionTime(),
            
            // Financial KPIs
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'monthly_revenue' => Order::where('status', 'completed')
                ->where('created_at', '>=', $lastMonth)
                ->sum('total_amount'),
            'revenue_growth_rate' => $this->calculateRevenueGrowthRate(),
        ];
    }

    /**
     * Get Manufacturer KPIs
     */
    public function getManufacturerKPIs($manufacturerId)
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();
        
        return [
            // Production KPIs
            'total_production_batches' => ProductionBatch::where('manufacturer_id', $manufacturerId)->count(),
            'completed_batches' => ProductionBatch::where('manufacturer_id', $manufacturerId)
                ->where('status', 'completed')->count(),
            'production_efficiency' => $this->calculateProductionEfficiency($manufacturerId),
            'average_production_time' => $this->calculateAverageProductionTime($manufacturerId),
            
            // Inventory KPIs
            'total_inventory' => Inventory::where('manufacturer_id', $manufacturerId)->sum('quantity'),
            'inventory_value' => Inventory::where('manufacturer_id', $manufacturerId)
                ->sum(DB::raw('quantity * unit_price')),
            'low_stock_alerts' => Inventory::where('manufacturer_id', $manufacturerId)
                ->where('quantity', '<=', DB::raw('reorder_level'))->count(),
            
            // Order KPIs
            'pending_orders' => PurchaseOrder::where('manufacturer_id', $manufacturerId)
                ->where('status', 'pending')->count(),
            'completed_orders' => PurchaseOrder::where('manufacturer_id', $manufacturerId)
                ->where('status', 'completed')->count(),
            'order_fulfillment_rate' => $this->calculateManufacturerOrderFulfillmentRate($manufacturerId),
            
            // Quality KPIs
            'quality_rating' => $this->calculateQualityRating($manufacturerId),
            'defect_rate' => $this->calculateDefectRate($manufacturerId),
        ];
    }

    /**
     * Get Supplier KPIs
     */
    public function getSupplierKPIs($supplierId)
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();
        
        return [
            // Material KPIs
            'total_materials' => RawMaterial::where('supplier_id', $supplierId)->count(),
            'available_materials' => RawMaterial::where('supplier_id', $supplierId)
                ->where('quantity', '>', 0)->count(),
            'low_stock_materials' => RawMaterial::where('supplier_id', $supplierId)
                ->where('quantity', '<=', DB::raw('reorder_level'))->count(),
            
            // Order KPIs
            'total_orders' => PurchaseOrder::where('supplier_id', $supplierId)->count(),
            'pending_orders' => PurchaseOrder::where('supplier_id', $supplierId)
                ->where('status', 'pending')->count(),
            'completed_orders' => PurchaseOrder::where('supplier_id', $supplierId)
                ->where('status', 'completed')->count(),
            'order_fulfillment_rate' => $this->calculateSupplierOrderFulfillmentRate($supplierId),
            
            // Financial KPIs
            'total_sales' => PurchaseOrder::where('supplier_id', $supplierId)
                ->where('status', 'completed')->sum('total_amount'),
            'monthly_sales' => PurchaseOrder::where('supplier_id', $supplierId)
                ->where('status', 'completed')
                ->where('created_at', '>=', $lastMonth)
                ->sum('total_amount'),
            'sales_growth_rate' => $this->calculateSupplierSalesGrowthRate($supplierId),
            
            // Performance KPIs
            'on_time_delivery_rate' => $this->calculateOnTimeDeliveryRate($supplierId),
            'quality_rating' => $this->calculateSupplierQualityRating($supplierId),
        ];
    }

    /**
     * Get Retailer KPIs
     */
    public function getRetailerKPIs($retailerId)
    {
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonth();
        
        return [
            // Sales KPIs
            'total_orders' => Order::where('retailer_id', $retailerId)->count(),
            'completed_orders' => Order::where('retailer_id', $retailerId)
                ->where('status', 'completed')->count(),
            'total_revenue' => Order::where('retailer_id', $retailerId)
                ->where('status', 'completed')->sum('total_amount'),
            'monthly_revenue' => Order::where('retailer_id', $retailerId)
                ->where('status', 'completed')
                ->where('created_at', '>=', $lastMonth)
                ->sum('total_amount'),
            'revenue_growth_rate' => $this->calculateRetailerRevenueGrowthRate($retailerId),
            
            // Customer KPIs
            'customer_satisfaction' => $this->calculateCustomerSatisfaction($retailerId),
            'customer_retention_rate' => $this->calculateCustomerRetentionRate($retailerId),
            'average_order_value' => $this->calculateAverageOrderValue($retailerId),
            
            // Delivery KPIs
            'on_time_deliveries' => DeliverySchedule::where('retailer_id', $retailerId)
                ->where('status', 'delivered')
                ->where('delivery_date', '<=', DB::raw('scheduled_date'))
                ->count(),
            'total_deliveries' => DeliverySchedule::where('retailer_id', $retailerId)
                ->where('status', 'delivered')->count(),
            'delivery_performance' => $this->calculateDeliveryPerformance($retailerId),
        ];
    }

    /**
     * Get Vendor KPIs
     */
    public function getVendorKPIs($userId)
    {
        return [
            // Application KPIs
            'total_applications' => VendorApplication::count(),
            'pending_applications' => VendorApplication::where('status', 'pending')->count(),
            'approved_applications' => VendorApplication::where('status', 'approved')->count(),
            'rejected_applications' => VendorApplication::where('status', 'rejected')->count(),
            'approval_rate' => $this->calculateVendorApprovalRate(),
            
            // Process KPIs
            'average_processing_time' => $this->calculateAverageApplicationProcessingTime(),
            'application_success_rate' => $this->calculateApplicationSuccessRate(),
        ];
    }

    // Helper methods for calculations
    private function calculateGrowthRate($type)
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        switch ($type) {
            case 'users':
                $currentCount = User::where('created_at', '>=', $currentMonth)->count();
                $lastCount = User::where('created_at', '>=', $lastMonth)
                    ->where('created_at', '<', $currentMonth)->count();
                break;
            default:
                return 0;
        }
        
        return $lastCount > 0 ? (($currentCount - $lastCount) / $lastCount) * 100 : 0;
    }

    private function calculateOrderFulfillmentRate()
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        return $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
    }

    private function calculateAverageOrderProcessingTime()
    {
        $orders = Order::where('status', 'completed')
            ->whereNotNull('created_at')
            ->whereNotNull('updated_at')
            ->get();
        
        if ($orders->isEmpty()) return 0;
        
        $totalTime = $orders->sum(function ($order) {
            return Carbon::parse($order->created_at)->diffInHours($order->updated_at);
        });
        
        return round($totalTime / $orders->count(), 2);
    }

    private function calculateInventoryTurnoverRate()
    {
        // Simplified calculation - in real scenario, you'd need more detailed data
        $totalInventory = Inventory::sum('quantity');
        $totalSales = Order::where('status', 'completed')->sum('quantity');
        
        return $totalInventory > 0 ? ($totalSales / $totalInventory) : 0;
    }

    private function calculateVendorApprovalRate()
    {
        $totalApplications = VendorApplication::count();
        $approvedApplications = VendorApplication::where('status', 'approved')->count();
        
        return $totalApplications > 0 ? ($approvedApplications / $totalApplications) * 100 : 0;
    }

    private function calculateTaskCompletionRate()
    {
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        
        return $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
    }

    private function calculateAverageTaskCompletionTime()
    {
        $tasks = Task::where('status', 'completed')
            ->whereNotNull('created_at')
            ->whereNotNull('updated_at')
            ->get();
        
        if ($tasks->isEmpty()) return 0;
        
        $totalTime = $tasks->sum(function ($task) {
            return Carbon::parse($task->created_at)->diffInHours($task->updated_at);
        });
        
        return round($totalTime / $tasks->count(), 2);
    }

    private function calculateRevenueGrowthRate()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        $currentRevenue = Order::where('status', 'completed')
            ->where('created_at', '>=', $currentMonth)
            ->sum('total_amount');
        
        $lastRevenue = Order::where('status', 'completed')
            ->where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->sum('total_amount');
        
        return $lastRevenue > 0 ? (($currentRevenue - $lastRevenue) / $lastRevenue) * 100 : 0;
    }

    // Additional helper methods for specific role calculations
    private function calculateProductionEfficiency($manufacturerId)
    {
        $batches = ProductionBatch::where('manufacturer_id', $manufacturerId)
            ->where('status', 'completed')->get();
        
        if ($batches->isEmpty()) return 0;
        
        $totalEfficiency = $batches->sum('efficiency_rate');
        return round($totalEfficiency / $batches->count(), 2);
    }

    private function calculateAverageProductionTime($manufacturerId)
    {
        $batches = ProductionBatch::where('manufacturer_id', $manufacturerId)
            ->where('status', 'completed')
            ->whereNotNull('start_date')
            ->whereNotNull('completion_date')
            ->get();
        
        if ($batches->isEmpty()) return 0;
        
        $totalTime = $batches->sum(function ($batch) {
            return Carbon::parse($batch->start_date)->diffInHours($batch->completion_date);
        });
        
        return round($totalTime / $batches->count(), 2);
    }

    private function calculateManufacturerOrderFulfillmentRate($manufacturerId)
    {
        $totalOrders = PurchaseOrder::where('manufacturer_id', $manufacturerId)->count();
        $completedOrders = PurchaseOrder::where('manufacturer_id', $manufacturerId)
            ->where('status', 'completed')->count();
        
        return $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
    }

    private function calculateQualityRating($manufacturerId)
    {
        // Placeholder - implement based on your quality metrics
        return 95.5;
    }

    private function calculateDefectRate($manufacturerId)
    {
        // Placeholder - implement based on your defect tracking
        return 2.3;
    }

    private function calculateSupplierOrderFulfillmentRate($supplierId)
    {
        $totalOrders = PurchaseOrder::where('supplier_id', $supplierId)->count();
        $completedOrders = PurchaseOrder::where('supplier_id', $supplierId)
            ->where('status', 'completed')->count();
        
        return $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
    }

    private function calculateSupplierSalesGrowthRate($supplierId)
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        $currentSales = PurchaseOrder::where('supplier_id', $supplierId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $currentMonth)
            ->sum('total_amount');
        
        $lastSales = PurchaseOrder::where('supplier_id', $supplierId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->sum('total_amount');
        
        return $lastSales > 0 ? (($currentSales - $lastSales) / $lastSales) * 100 : 0;
    }

    private function calculateOnTimeDeliveryRate($supplierId)
    {
        // Placeholder - implement based on your delivery tracking
        return 94.2;
    }

    private function calculateSupplierQualityRating($supplierId)
    {
        // Placeholder - implement based on your quality metrics
        return 96.8;
    }

    private function calculateRetailerRevenueGrowthRate($retailerId)
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        $currentRevenue = Order::where('retailer_id', $retailerId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $currentMonth)
            ->sum('total_amount');
        
        $lastRevenue = Order::where('retailer_id', $retailerId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->sum('total_amount');
        
        return $lastRevenue > 0 ? (($currentRevenue - $lastRevenue) / $lastRevenue) * 100 : 0;
    }

    private function calculateCustomerSatisfaction($retailerId)
    {
        // Placeholder - implement based on your customer feedback system
        return 4.6;
    }

    private function calculateCustomerRetentionRate($retailerId)
    {
        // Placeholder - implement based on your customer data
        return 87.3;
    }

    private function calculateAverageOrderValue($retailerId)
    {
        $orders = Order::where('retailer_id', $retailerId)
            ->where('status', 'completed')->get();
        
        if ($orders->isEmpty()) return 0;
        
        return round($orders->sum('total_amount') / $orders->count(), 2);
    }

    private function calculateDeliveryPerformance($retailerId)
    {
        $totalDeliveries = DeliverySchedule::where('retailer_id', $retailerId)
            ->where('status', 'delivered')->count();
        
        $onTimeDeliveries = DeliverySchedule::where('retailer_id', $retailerId)
            ->where('status', 'delivered')
            ->where('delivery_date', '<=', DB::raw('scheduled_date'))
            ->count();
        
        return $totalDeliveries > 0 ? ($onTimeDeliveries / $totalDeliveries) * 100 : 0;
    }

    private function calculateAverageApplicationProcessingTime()
    {
        $applications = VendorApplication::where('status', '!=', 'pending')
            ->whereNotNull('created_at')
            ->whereNotNull('updated_at')
            ->get();
        
        if ($applications->isEmpty()) return 0;
        
        $totalTime = $applications->sum(function ($application) {
            return Carbon::parse($application->created_at)->diffInDays($application->updated_at);
        });
        
        return round($totalTime / $applications->count(), 1);
    }

    private function calculateApplicationSuccessRate()
    {
        $totalApplications = VendorApplication::count();
        $successfulApplications = VendorApplication::where('status', 'approved')->count();
        
        return $totalApplications > 0 ? ($successfulApplications / $totalApplications) * 100 : 0;
    }
}
