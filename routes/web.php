<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Supplier\DashboardController as SupplierDashboardController;
use App\Http\Controllers\Manufacturer\DashboardController as ManufacturerDashboardController;
use App\Http\Controllers\Retailer\DashboardController as RetailerDashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::patch('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::patch('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

// Admin Routes
Route::middleware(['auth', 'role:administrator', 'redirect.role'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [AdminDashboardController::class, 'userManagement'])->name('admin.users.index');
    Route::get('/vendor-applications', [AdminDashboardController::class, 'vendorApplications'])->name('admin.vendors.applications');
    Route::post('/vendor-applications/{id}/approve', [AdminDashboardController::class, 'approveVendorApplication'])->name('admin.vendors.approve');
    Route::post('/vendor-applications/{id}/reject', [AdminDashboardController::class, 'rejectVendorApplication'])->name('admin.vendors.reject');
});

// Supplier Routes
Route::middleware(['auth', 'role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Supplier\DashboardController::class, 'index'])->name('dashboard');
    
    // Materials Routes
    Route::get('/materials', [App\Http\Controllers\Supplier\DashboardController::class, 'materials'])->name('materials');
    Route::put('/materials/{id}', [App\Http\Controllers\Supplier\DashboardController::class, 'updateMaterial'])->name('materials.update');
    
    // Orders Routes
    Route::get('/orders', [App\Http\Controllers\Supplier\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Supplier\OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [App\Http\Controllers\Supplier\OrderController::class, 'updateStatus'])->name('orders.status');
    
    // Chat Routes
    Route::get('/chats', [App\Http\Controllers\Supplier\ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{id}', [App\Http\Controllers\Supplier\ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats', [App\Http\Controllers\Supplier\ChatController::class, 'store'])->name('chats.store');
    Route::put('/chats/{id}/read', [App\Http\Controllers\Supplier\ChatController::class, 'markAsRead'])->name('chats.read');
});

// Manufacturer Routes
Route::middleware(['auth', 'role:manufacturer', 'redirect.role'])->prefix('manufacturer')->group(function () {
    Route::get('/dashboard', [ManufacturerDashboardController::class, 'index'])->name('manufacturer.dashboard');
    Route::get('/inventory', [ManufacturerDashboardController::class, 'inventory'])->name('manufacturer.inventory.index');
    Route::put('/inventory/{id}', [ManufacturerDashboardController::class, 'updateInventory'])->name('manufacturer.inventory.update');
    Route::get('/production-batches', [ManufacturerDashboardController::class, 'productionBatches'])->name('manufacturer.production.batches');
    Route::post('/production-batches', [ManufacturerDashboardController::class, 'createProductionBatch'])->name('manufacturer.production.create');
    Route::get('/chat/{supplierId}', [ManufacturerDashboardController::class, 'chatWithSupplier'])->name('manufacturer.chat');
});

// Retailer Routes
Route::middleware(['auth', 'role:retailer', 'redirect.role'])->prefix('retailer')->group(function () {
    Route::get('/dashboard', [RetailerDashboardController::class, 'index'])->name('retailer.dashboard');
    Route::get('/orders', [RetailerDashboardController::class, 'orders'])->name('retailer.orders.index');
    Route::post('/orders', [RetailerDashboardController::class, 'createOrder'])->name('retailer.orders.create');
    Route::get('/orders/{id}/track', [RetailerDashboardController::class, 'trackOrder'])->name('retailer.orders.track');
    Route::get('/reports', [RetailerDashboardController::class, 'reports'])->name('retailer.reports.index');
});

