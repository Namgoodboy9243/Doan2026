<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Homecontroller;
use App\Http\Controllers\Admincontroller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
route::get('index',[Homecontroller::class, 'index']);
route::get('category',[Homecontroller::class, 'category']);
route::get('search',[Homecontroller::class, 'search'])->name('search');
route::get('search/suggestions',[Homecontroller::class, 'suggestions'])->name('search.suggestions');
route::get('product/{id}',[Homecontroller::class, 'detail'])->name('product.detail');

// Các route giỏ hàng yêu cầu Đăng nhập mới có thể truy cập hoặc mua sắm
Route::middleware(['auth.buy'])->group(function () {
    Route::get('cart', [Homecontroller::class, 'cart'])->name('cart');
    Route::get('cart/print', [Homecontroller::class, 'printQuotation'])->name('cart.print');
    Route::post('cart/add', [Homecontroller::class, 'addToCart'])->name('cart.add');
    Route::post('cart/update', [Homecontroller::class, 'updateCart'])->name('cart.update');
    Route::post('cart/remove', [Homecontroller::class, 'removeFromCart'])->name('cart.remove');
    Route::post('cart/clear', [Homecontroller::class, 'clearCart'])->name('cart.clear');
    Route::post('checkout', [Homecontroller::class, 'checkout'])->name('checkout');
    Route::post('checkout/create-ajax', [Homecontroller::class, 'checkoutAjax'])->name('checkout.create.ajax');
    Route::get('order-history', [Homecontroller::class, 'orderHistory'])->name('order.history');
    Route::post('order/cancel/{id}', [Homecontroller::class, 'cancelOrder'])->name('order.cancel');
    Route::post('checkout/VNpay',[Homecontroller::class,'checkoutVNpay'])->name('thanhtoan.vnpay');
    Route::get('checkout/check-status/{id}', [Homecontroller::class, 'checkOrderStatus'])->name('checkout.check_status');
    Route::get('checkout/simulate-payment/{id}', [Homecontroller::class, 'simulatePayment'])->name('checkout.simulate_payment');
    Route::get('checkout/cancel-order/{id}', [Homecontroller::class, 'cancelQROrder'])->name('checkout.cancel_order');
});

// Các route Xác thực tài khoản dành cho Khách vãng lai
Route::middleware(['guest'])->group(function () {
    Route::get('login', [Homecontroller::class, 'showLogin'])->name('login');
    Route::post('login', [Homecontroller::class, 'login']);
    Route::get('register', [Homecontroller::class, 'showRegister'])->name('register');
    Route::post('register', [Homecontroller::class, 'register']);
});

// Đăng xuất (Yêu cầu đã đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::post('logout', [Homecontroller::class, 'logout'])->name('logout');
});





// Admin Authentication Routes (Guest / Public)
Route::get('admin/login', [Admincontroller::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [Admincontroller::class, 'login']);

// Secure Admin Routes (Protected by admin.auth)
Route::middleware(['admin.auth'])->group(function () {
    Route::post('admin/logout', [Admincontroller::class, 'logout'])->name('admin.logout');

    Route::get('admin', [Admincontroller::class, 'admin']);
    Route::get('add-category', [Admincontroller::class, 'addCategory'])->name('admin.category.addCategory');
    Route::post('add-category', [Admincontroller::class, 'addCategoryPost'])->name('admin.category_post.addCategory');
    Route::get('products-table', [Admincontroller::class, 'products_table'])->name('admin.products.table');
    Route::get('add-products', [Admincontroller::class, 'addProducts'])->name('admin.products.addProducts');
    Route::post('add-products', [Admincontroller::class, 'addProductsPost'])->name('admin.products_post.addProducts');
    Route::get('edit-product/{id}', [Admincontroller::class, 'editProduct'])->name('admin.products.edit');
    Route::post('edit-product/{id}', [Admincontroller::class, 'editProductPost'])->name('admin.products_post.edit');
    Route::get('delete-product/{id}', [Admincontroller::class, 'deleteProduct'])->name('admin.products.delete');
    Route::get('delete-detail-image/{id}', [Admincontroller::class, 'deleteDetailImage'])->name('admin.products.delete_detail_image');
    Route::get('delete-variant/{id}', [Admincontroller::class, 'deleteVariant'])->name('admin.products.delete_variant');
    Route::get('products/suggestions', [Admincontroller::class, 'productSuggestions'])->name('admin.products.suggestions');

    // Admin Order Management Routes
    Route::get('admin/orders', [Admincontroller::class, 'orders_table'])->name('admin.orders.table');
    Route::post('admin/orders/update-status/{id}', [Admincontroller::class, 'update_order_status'])->name('admin.orders.update_status');
    Route::get('admin/orders/detail/{id}', [Admincontroller::class, 'order_detail_json'])->name('admin.orders.detail');
});

// Route test WebSocket độc lập
Route::get('test-broadcast', function() {
    $driver = config('broadcasting.default');
    $config = config('broadcasting.connections.pusher');

    $order = \App\Models\order::first();
    if (!$order) {
        $order = \App\Models\order::create([
            'name' => 'Khách Hàng Test',
            'email' => 'test@spatacus.com',
            'phone' => '0999888777',
            'address' => 'Hà Nội, Việt Nam',
            'customer_id' => 1,
            'status' => 1
        ]);
    }
    event(new \App\Events\OrderPlaced($order));
    
    return response()->json([
        'message' => 'Đã kích hoạt phát sự kiện OrderPlaced thành công!',
        'driver_class_used' => $driver,
        'broadcasting_config' => $config,
        'note' => 'Nếu driver_class_used là "log" hoặc config không có 127.0.0.1/6001, bạn cần tắt và khởi chạy lại câu lệnh "php artisan serve"!'
    ]);
});

Route::get('test-pusher-direct', function() {
    $driver = config('broadcasting.default');
    $config = config('broadcasting.connections.pusher');
    
    $options = $config['options'] ?? [];
    
    try {
        $pusher = new \Pusher\Pusher(
            $config['key'],
            $config['secret'],
            $config['app_id'],
            $options
        );
        
        $res = $pusher->trigger('admin-notifications', 'OrderPlaced', [
            'id' => 999,
            'name' => 'Direct Pusher Test Customer',
            'phone' => '0123456789',
            'address' => 'Test Address',
            'status' => 1
        ]);
        
        return response()->json([
            'success' => true,
            'result' => $res,
            'driver' => $driver,
            'options_used' => $options
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'driver' => $driver,
            'options_used' => $options
        ]);
    }
});

