<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Supplier\DashboardController as SupplierDashboardController;
use App\Http\Controllers\Manufacturer\DashboardController as ManufacturerDashboardController;
use App\Http\Controllers\Retailer\DashboardController as RetailerDashboardController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Manufacturer\ChatController as ManufacturerChatController;
use App\Http\Controllers\TestChatController;
use App\Http\Controllers\SupplierChatController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Simple test route to verify routing works
Route::get('/test-hello', function() {
    return 'Hello, world!';
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// TEST: Minimal route at the very top
Route::get('/test-chat-top', [TestChatController::class, 'index'])->name('test.chat.top');

Route::get('/test', function () {
    return 'Test route is working!';
});

// Authentication Routes
Auth::routes();

// Restore GET logout route for compatibility with old behavior
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

// Admin Routes
Route::middleware(['auth', 'role:administrator', 'redirect.role'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminDashboardController::class, 'userManagement'])->name('admin.users.index');
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('admin.orders.index');
    Route::get('/vendor-applications', [AdminDashboardController::class, 'vendorApplications'])->name('admin.vendors.applications');
    Route::post('/vendor-applications/{id}/approve', [AdminDashboardController::class, 'approveVendorApplication'])->name('admin.vendors.approve');
    Route::post('/vendor-applications/{id}/reject', [AdminDashboardController::class, 'rejectVendorApplication'])->name('admin.vendors.reject');
    Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('admin.analytics');
    Route::get('/analytics/demand-forecast', [AdminDashboardController::class, 'demandForecast'])->name('admin.analytics.demand-forecast');
    Route::get('/analytics/customer-segmentation', [AdminDashboardController::class, 'customerSegmentation'])->name('admin.analytics.customer-segmentation');
    Route::get('/analytics/customer-segmentation/summary', [AdminDashboardController::class, 'customerSegmentationSummary'])->name('admin.analytics.customer-segmentation.summary');
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'getAdminNotifications'])->name('admin.notifications');
    Route::get('/work-distribution', [App\Http\Controllers\Admin\WorkDistributionController::class, 'index'])->name('admin.work-distribution.index');
    Route::get('/work-distribution/create', [App\Http\Controllers\Admin\WorkDistributionController::class, 'create'])->name('admin.work-distribution.create');
    Route::get('/tasks', [App\Http\Controllers\Admin\TaskController::class, 'index'])->name('admin.tasks.index');
    Route::get('/tasks/reports', [App\Http\Controllers\Admin\TaskController::class, 'reports'])->name('admin.tasks.reports');
    Route::get('/tasks/create', [App\Http\Controllers\Admin\TaskController::class, 'create'])->name('admin.tasks.create');
});

// Vendor Routes
Route::middleware(['auth', 'role:vendor', 'redirect.role'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    
    // Applications Routes
    Route::get('/applications', [VendorDashboardController::class, 'applications'])->name('applications.index');
    Route::get('/applications/create', [VendorDashboardController::class, 'createApplication'])->name('applications.create');
    Route::post('/applications', [VendorDashboardController::class, 'storeApplication'])->name('applications.store');
    Route::get('/applications/{id}', [VendorDashboardController::class, 'showApplication'])->name('applications.show');
    Route::get('/applications/{id}/download', [VendorDashboardController::class, 'downloadPdf'])->name('applications.download');
    
    // Visit Management Routes (require valid application)
    Route::middleware(['check.vendor.application'])->group(function () {
    Route::get('/applications/{id}/schedule-visit', [VendorDashboardController::class, 'scheduleVisit'])->name('applications.schedule-visit');
    Route::post('/applications/{id}/visit-result', [VendorDashboardController::class, 'storeVisitResult'])->name('applications.visit-result');
    });
    
    // Reports Routes (require valid application)
    Route::middleware(['check.vendor.application'])->group(function () {
    Route::get('/reports', [VendorDashboardController::class, 'reports'])->name('reports');
    });
});

// Supplier Routes
Route::middleware(['auth', 'role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Supplier\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [App\Http\Controllers\Supplier\NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/api', [App\Http\Controllers\Supplier\NotificationController::class, 'getNotifications'])->name('notifications.api');
    Route::get('/notifications/stats', [App\Http\Controllers\Supplier\NotificationController::class, 'getStats'])->name('notifications.stats');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\Supplier\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\Supplier\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Supplier\NotificationController::class, 'delete'])->name('notifications.delete');
    Route::delete('/notifications', [App\Http\Controllers\Supplier\NotificationController::class, 'clearAll'])->name('notifications.clear-all');
    
    // Materials Routes
    Route::get('/materials', [App\Http\Controllers\Supplier\DashboardController::class, 'materials'])->name('materials');
    Route::put('/materials/{id}', [App\Http\Controllers\Supplier\DashboardController::class, 'updateMaterial'])->name('materials.update');
    Route::get('/materials/api', [App\Http\Controllers\Supplier\DashboardController::class, 'apiMaterials'])->name('materials.api');
    Route::post('/materials', [App\Http\Controllers\Supplier\DashboardController::class, 'storeMaterial'])->name('materials.store');
    
    // Orders Routes
    Route::get('/orders', [App\Http\Controllers\Supplier\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Supplier\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [App\Http\Controllers\Supplier\OrderController::class, 'updateStatus'])->name('orders.status');
    
    // Chat Routes
    Route::get('/chats', [App\Http\Controllers\Supplier\ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{manufacturerId}', [App\Http\Controllers\Supplier\ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats', [App\Http\Controllers\Supplier\ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/{manufacturerId}/messages', [App\Http\Controllers\Supplier\ChatController::class, 'getMessages'])->name('chats.messages');
    Route::put('/chats/{id}/read', [App\Http\Controllers\Supplier\ChatController::class, 'markAsRead'])->name('chats.read');
    Route::get('/chats/unread/count', [App\Http\Controllers\Supplier\ChatController::class, 'getUnreadCount'])->name('chats.unread-count');
});

// Manufacturer Routes - Fixed and consolidated
Route::middleware(['auth', 'role:manufacturer', 'redirect.role'])->prefix('manufacturer')->group(function () {
    // Dashboard and Analytics
    Route::get('/dashboard', [ManufacturerDashboardController::class, 'index'])->name('manufacturer.dashboard');
    Route::get('/analytics', [ManufacturerDashboardController::class, 'analytics'])->name('manufacturer.analytics');
    Route::get('/notifications', [ManufacturerDashboardController::class, 'notifications'])->name('manufacturer.notifications');
    
    // Inventory Routes
    Route::get('/inventory', [ManufacturerDashboardController::class, 'inventory'])->name('manufacturer.inventory.index');
    Route::put('/inventory/{id}', [ManufacturerDashboardController::class, 'updateInventory'])->name('manufacturer.inventory.update');
    Route::post('/inventory', [ManufacturerDashboardController::class, 'storeInventory'])->name('manufacturer.inventory.store');
    Route::get('/inventory/{id}/history', [ManufacturerDashboardController::class, 'inventoryHistory'])->name('manufacturer.inventory.history');
    Route::get('/inventory/report', [ManufacturerDashboardController::class, 'inventoryReport'])->name('manufacturer.inventory.report');
    Route::get('/inventory/alerts', [ManufacturerDashboardController::class, 'stockAlerts'])->name('manufacturer.inventory.alerts');
    Route::post('/inventory/bulk-update', [ManufacturerDashboardController::class, 'bulkUpdateInventory'])->name('manufacturer.inventory.bulk-update');
    Route::get('/inventory/template', [ManufacturerDashboardController::class, 'downloadInventoryTemplate'])->name('manufacturer.inventory.template');
    
    // Production Routes
    Route::get('/production/batches', [ManufacturerDashboardController::class, 'productionBatches'])->name('manufacturer.production.batches');
    Route::post('/production/batches', [ManufacturerDashboardController::class, 'createProductionBatch'])->name('manufacturer.production.batches.store');
    Route::post('/production/batches/{id}/status', [ManufacturerDashboardController::class, 'updateBatchStatus'])->name('manufacturer.production.batches.status');
    Route::get('/production/batches/data', [ManufacturerDashboardController::class, 'getBatchesData'])->name('manufacturer.production.batches.data');
    Route::get('/production/batches/{id}', [ManufacturerDashboardController::class, 'getBatchDetails'])->name('manufacturer.production.batches.details');
    Route::post('/production/batches/{id}', [ManufacturerDashboardController::class, 'updateProductionBatch'])->name('manufacturer.production.batches.update');
    Route::get('/production/report', [ManufacturerDashboardController::class, 'productionReport'])->name('manufacturer.production.report');
    
    // Orders Routes
    Route::get('/orders', [ManufacturerDashboardController::class, 'orders'])->name('manufacturer.orders');
    Route::post('/orders/{id}/process', [ManufacturerDashboardController::class, 'processOrder'])->name('manufacturer.orders.process');
    Route::post('/orders/{id}/assign-delivery', [ManufacturerDashboardController::class, 'assignDelivery'])->name('manufacturer.orders.assign-delivery');
    Route::post('/orders/{id}/update-delivery', [ManufacturerDashboardController::class, 'updateDeliveryStatus'])->name('manufacturer.orders.update-delivery');
    Route::get('/orders/{id}', [ManufacturerDashboardController::class, 'orderDetails'])->name('manufacturer.orders.details');
    
    // Raw Material Orders Routes
    Route::get('/raw-material-orders', [ManufacturerDashboardController::class, 'rawMaterialOrders'])->name('manufacturer.raw-material-orders');
    Route::post('/raw-material-orders', [ManufacturerDashboardController::class, 'storeRawMaterialOrder'])->name('manufacturer.raw-material-orders.store');
    Route::get('/raw-material-orders/{id}', [ManufacturerDashboardController::class, 'rawMaterialOrderDetails'])->name('manufacturer.raw-material-orders.details');
    
    // Delivery Routes
    Route::post('/deliveries/{id}/update-status', [ManufacturerDashboardController::class, 'updateDeliveryStatus'])->name('manufacturer.deliveries.update-status');
    
    // Notification Routes
    Route::delete('/notifications', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('manufacturer.notifications.clear-all');
    Route::get('/notifications/stats', [App\Http\Controllers\NotificationController::class, 'getStats'])->name('manufacturer.notifications.stats');
    
    // Report Routes
    Route::get('/efficiency-report', [ManufacturerDashboardController::class, 'efficiencyReport'])->name('efficiency.report');
    Route::get('/financial-report', [ManufacturerDashboardController::class, 'financialReport'])->name('financial.report');
    
    // Chat Routes - Working chat functionality
    Route::get('/chats', [ManufacturerChatController::class, 'index'])->name('manufacturer.chats.index');
    Route::get('/chats/{supplierId}', [ManufacturerChatController::class, 'show'])->name('manufacturer.chats.show');
    Route::post('/chats', [ManufacturerChatController::class, 'store'])->name('manufacturer.chats.store');
    Route::get('/chats/{supplierId}/messages', [ManufacturerChatController::class, 'getMessages'])->name('manufacturer.chats.messages');
    Route::put('/chats/{id}/read', [ManufacturerChatController::class, 'markAsRead'])->name('manufacturer.chats.read');
    Route::get('/chats/unread/count', [ManufacturerChatController::class, 'getUnreadCount'])->name('manufacturer.chats.unread-count');
    
    // Test route for debugging
    Route::get('/test-chat-simple', function() {
        return 'Manufacturer chat test route is working!';
    })->name('manufacturer.test.chat');

    Route::get('/static-chat', function() {
        return view('manufacturer.static-chat', [
            'activePage' => 'static-chat',
            'title' => 'Static Chat - BWSCMS',
            'activeButton' => 'manufacturer',
            'navName' => 'Static Chat'
        ]);
    })->name('manufacturer.static-chat');
});

// Retailer Routes
Route::middleware(['auth', 'role:retailer', 'redirect.role'])->prefix('retailer')->group(function () {
    Route::get('/dashboard', [RetailerDashboardController::class, 'index'])->name('retailer.dashboard');
    Route::get('/orders', [RetailerDashboardController::class, 'orders'])->name('retailer.orders.index');
    Route::post('/orders', [RetailerDashboardController::class, 'createOrder'])->name('retailer.orders.create');
    Route::get('/orders/{id}/track', [RetailerDashboardController::class, 'trackOrder'])->name('retailer.orders.track');
    Route::get('/reports', [RetailerDashboardController::class, 'reports'])->name('retailer.reports.index');
    Route::get('/reports/api', [App\Http\Controllers\Retailer\DashboardController::class, 'apiReports'])->name('retailer.reports.api');
    // Retailer Notifications Route
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('retailer.notifications');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'delete']);
    Route::delete('/notifications/clear-all', [App\Http\Controllers\NotificationController::class, 'clearAll']);
});

Route::get('/test-report-view', function() {
    return 'Route works!';
});

Route::get('/test-view', function() {
    return view('test');
});

// This must be last! Catch-all route
Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\\Http\\Controllers\\PageController@index']);
});

// Test route for debugging production batch creation
Route::get('/test-production-batch', function () {
    return response()->json([
        'success' => true,
        'message' => 'Test route working',
        'products' => \App\Models\Product::where('status', 'active')->get(['id', 'name']),
        'user_id' => auth()->id(),
        'csrf_token' => csrf_token()
    ]);
})->middleware(['auth', 'role:manufacturer']);

// Test route for production batch creation (GET method for testing)
Route::get('/test-create-production-batch', function () {
    try {
        $batch = \App\Models\ProductionBatch::create([
            'manufacturer_id' => auth()->id(),
            'product_id' => 1,
            'quantity' => 100,
            'production_date' => '2024-01-01',
            'start_date' => '2024-01-01',
            'estimated_completion' => '2024-01-05',
            'status' => 'pending',
            'notes' => 'Test batch from GET route',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Test batch created successfully',
            'batch_id' => $batch->id
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
})->middleware(['auth', 'role:manufacturer']);

// TEST: Register chat route outside group to debug
Route::get('/test-chats', [App\Http\Controllers\Manufacturer\ChatController::class, 'index'])->name('test.chats');

// TEST: Register TestChatController route outside group to debug
Route::get('/test-chat-alt', [TestChatController::class, 'index'])->name('test.chat.alt');

// Minimal manufacturer-supplier chat test route
Route::get('/manufacturer/supplier-chat', [HomeController::class, 'supplierChat'])->name('manufacturer.supplier.chat');

// Test database connection
Route::get('/test-db-connection', function() {
    try {
        $userCount = \App\Models\User::count();
        return response()->json([
            'success' => true,
            'count' => $userCount,
            'message' => 'Database connection successful'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Database connection failed: ' . $e->getMessage()
        ], 500);
    }
});

// Test supplier chat functionality
Route::get('/test-supplier-chat', function() {
    try {
        $suppliers = \App\Models\User::where('role', 'supplier')->get();
        $manufacturers = \App\Models\User::where('role', 'manufacturer')->get();
        $chats = \App\Models\Chat::count();
        
        return response()->json([
            'success' => true,
            'suppliers_count' => $suppliers->count(),
            'manufacturers_count' => $manufacturers->count(),
            'total_chats' => $chats,
            'message' => 'Supplier chat test successful'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Supplier chat test failed: ' . $e->getMessage()
        ], 500);
    }
})->middleware(['auth', 'role:supplier']);
