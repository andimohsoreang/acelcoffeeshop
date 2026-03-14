<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;

// ============================================================
// USER ROUTES
// ============================================================

Route::get('/', [User\HomeController::class , 'index'])->name('home');

// Menu
Route::get('/menu', [User\MenuController::class , 'index'])->name('menu.index');
Route::get('/menu/{slug}', [User\MenuController::class , 'show'])->name('menu.show');

// Cart
Route::get('/cart', [User\CartController::class , 'index'])->name('cart.index');
Route::post('/cart/add', [User\CartController::class , 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [User\CartController::class , 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [User\CartController::class , 'remove'])->name('cart.remove');
Route::post('/cart/clear', [User\CartController::class , 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [User\CheckoutController::class , 'index'])->name('checkout.index');
Route::post('/checkout', [User\CheckoutController::class , 'store'])->name('checkout.store');
Route::post('/checkout/upload-proof/{order}', [User\CheckoutController::class , 'uploadProof'])->name('checkout.upload-proof');

// Orders
Route::get('/order/success/{orderCode}', [User\OrderController::class , 'success'])->name('order.success');
Route::get('/order/failed', [User\OrderController::class , 'failed'])->name('order.failed');
Route::get('/orders', [User\OrderController::class , 'index'])->name('order.index');
Route::get('/orders/{orderCode}', [User\OrderController::class , 'show'])->name('order.show');

// Reviews
Route::get('/reviews', [User\ReviewController::class , 'index'])->name('reviews.index');
Route::post('/reviews', [User\ReviewController::class , 'store'])->name('review.store');

// ============================================================
// ADMIN ROUTES
// ============================================================

Route::prefix('admin')->name('admin.')->group(function () {

    // ✅ Guest only — jika sudah login sebagai admin, redirect ke dashboard
    Route::middleware('guest')->group(function () {
            Route::get('/login', [Admin\AuthController::class , 'showLogin'])->name('login');
            Route::post('/login', [Admin\AuthController::class , 'login'])->name('login.post');
        }
        );

        // ✅ Logout di luar guest middleware — admin yang sudah login butuh akses ini
        Route::post('/logout', [Admin\AuthController::class , 'logout'])->name('logout');

        // ✅ Protected — hanya admin yang sudah login
        Route::middleware('admin')->group(function () {

            // Dashboard
            Route::get('/dashboard', [Admin\DashboardController::class , 'index'])->name('dashboard');
            Route::post('/test-notification', [Admin\DashboardController::class, 'testNotification'])->name('test-notification');

            // Showcases
            Route::get('/showcases', [Admin\ShowcaseController::class , 'index'])->name('showcases.index');

            // Categories
            Route::resource('categories', Admin\CategoryController::class);

            // Products
            Route::resource('products', Admin\ProductController::class);
            Route::patch('products/{product}/toggle', [Admin\ProductController::class , 'toggle'])->name('products.toggle');
            Route::delete('products/{product}/images/{image}', [Admin\ProductController::class, 'destroyImage'])->name('products.images.destroy');

            // Orders
            Route::get('/orders', [Admin\OrderController::class , 'index'])->name('orders.index');
            Route::get('/orders/{order}', [Admin\OrderController::class , 'show'])->name('orders.show');
            Route::patch('/orders/{order}/status', [Admin\OrderController::class , 'updateStatus'])->name('orders.update-status');
            Route::patch('/orders/{order}/payment/verify', [Admin\OrderController::class , 'verifyPayment'])->name('orders.payment.verify');
            Route::patch('/orders/{order}/payment/reject', [Admin\OrderController::class , 'rejectPayment'])->name('orders.payment.reject');

            // Menu Laporan Penjualan (Reports)
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [\App\Http\Controllers\Admin\ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    Route::get('/reports/export/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.exportPdf');

    // System Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Bank Accounts
    Route::resource('bank-accounts', \App\Http\Controllers\Admin\BankAccountController::class)->except(['create', 'show', 'edit']);

            // Customers
            Route::get('/customers', [Admin\CustomerController::class, 'index'])->name('customers.index');
            Route::get('/customers/{phone}', [Admin\CustomerController::class, 'show'])->name('customers.show');

            // QRIS
            Route::get('/qris', [Admin\QrisController::class , 'index'])->name('qris.index');
            Route::post('/qris', [Admin\QrisController::class , 'store'])->name('qris.store');
            Route::patch('/qris/{qris}', [Admin\QrisController::class , 'update'])->name('qris.update');
            Route::delete('/qris/{qris}', [Admin\QrisController::class , 'destroy'])->name('qris.destroy');

            // Finance
            Route::get('/finance', [Admin\FinanceController::class , 'index'])->name('finance.index');

            // Reviews
            Route::get('/reviews', [Admin\ReviewController::class , 'index'])->name('reviews.index');
            Route::patch('/reviews/{review}/approve', [Admin\ReviewController::class , 'approve'])->name('reviews.approve');
            Route::patch('/reviews/{review}/reject', [Admin\ReviewController::class , 'reject'])->name('reviews.reject');
            Route::delete('/reviews/{review}', [Admin\ReviewController::class , 'destroy'])->name('reviews.destroy');

        }
        );

    });