<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\CustomerAnalyticsController;
use App\Http\Controllers\PageController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop-by-categories', [ProductController::class, 'shopByCategories'])->name('shop.by-categories');
Route::get('/categories', [ProductController::class, 'shopByCategories'])->name('categories.index'); // Alias for backward compatibility
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->where('product', '[0-9]+');
Route::get('/category/{category}', [ProductController::class, 'byCategory'])->name('products.category')->where('category', '[0-9]+');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::get('/count', [CartController::class, 'count'])->name('count');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
});

// Coupon Routes
Route::prefix('coupons')->name('coupons.')->group(function () {
    Route::post('/apply', [CouponController::class, 'apply'])->name('apply');
    Route::delete('/remove', [CouponController::class, 'remove'])->name('remove');
});

// Wishlist Routes
Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
    Route::delete('/{wishlist}', [WishlistController::class, 'destroy'])->name('destroy');
    Route::post('/move-all-to-cart', [WishlistController::class, 'moveAllToCart'])->name('move-all-to-cart');
    Route::get('/count', [WishlistController::class, 'count'])->name('count');
});

// Payment Routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/callback', [PaymentController::class, 'callback'])->name('callback');
    Route::post('/webhook', [PaymentController::class, 'webhook'])->name('webhook');
    Route::get('/status/{order}', [PaymentController::class, 'checkStatus'])->name('status')->middleware('auth');
});

// Pages Routes
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'contactSubmit'])->name('contact.submit');
    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/refund', [PageController::class, 'refund'])->name('refund');
    Route::get('/shipping', [PageController::class, 'shipping'])->name('shipping');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
});

// Checkout Routes
Route::prefix('checkout')->middleware('auth')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{order?}', [CheckoutController::class, 'success'])->name('success');
    Route::get('/cancel', [CheckoutController::class, 'cancel'])->name('cancel');
});

// Profile Routes
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [ProfileController::class, 'update'])->name('update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [ProfileController::class, 'orderDetails'])->name('orders.show');
});

// Invoice Routes (ZATCA E-Invoice)
Route::middleware('auth')->prefix('invoices')->name('invoices.')->group(function () {
    Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('show');
    Route::get('/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('pdf');
    Route::get('/{invoice}/download', [InvoiceController::class, 'download'])->name('download');
});

// Phone Verification Routes
Route::middleware('auth')->prefix('phone')->name('phone.')->group(function () {
    Route::get('/verify', [\App\Http\Controllers\Auth\PhoneVerificationController::class, 'show'])->name('verify');
    Route::post('/send-code', [\App\Http\Controllers\Auth\PhoneVerificationController::class, 'sendCode'])->name('send-code');
    Route::post('/verify-code', [\App\Http\Controllers\Auth\PhoneVerificationController::class, 'verify'])->name('verify-code');
    Route::post('/resend', [\App\Http\Controllers\Auth\PhoneVerificationController::class, 'resend'])->name('resend');
});

// Auth Routes
require __DIR__.'/auth.php';

// Admin Routes - Protected and completely separated
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Products
        Route::resource('products', AdminProductController::class);
        Route::post('products/bulk-import', [AdminProductController::class, 'bulkImport'])->name('products.bulk-import');
        Route::get('products/export', [AdminProductController::class, 'export'])->name('products.export');
        
        // Categories
        Route::resource('categories', AdminCategoryController::class);
        
        // Orders
        Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        
        // Customers
        Route::resource('customers', AdminCustomerController::class)->except(['create', 'store']);
        
        // Coupons
        Route::resource('coupons', AdminCouponController::class);
        
        // Payments
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/dashboard', [AdminPaymentController::class, 'dashboard'])->name('dashboard');
            Route::get('/reports', [AdminPaymentController::class, 'reports'])->name('reports');
            Route::get('/export', [AdminPaymentController::class, 'export'])->name('export');
            Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
            Route::get('/{payment}', [AdminPaymentController::class, 'show'])->name('show');
            Route::post('/{payment}/refund', [AdminPaymentController::class, 'refund'])->name('refund');
        });
        
        // Settings
        Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [AdminSettingsController::class, 'update'])->name('settings.update');
        Route::post('settings/payment-credentials', [AdminSettingsController::class, 'updatePaymentCredentials'])->name('settings.payment-credentials');
        
        // Analytics & Customer Segmentation
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [CustomerAnalyticsController::class, 'index'])->name('index');
            Route::get('/segment/{segment}', [CustomerAnalyticsController::class, 'segment'])->name('segment');
            Route::get('/customer/{customer}', [CustomerAnalyticsController::class, 'customerDetails'])->name('customer');
            Route::get('/export/{segment}', [CustomerAnalyticsController::class, 'exportCustomers'])->name('export');
        });
        
        // Marketing Campaigns
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/', [CustomerAnalyticsController::class, 'campaigns'])->name('index');
            Route::get('/create', [CustomerAnalyticsController::class, 'createCampaign'])->name('create');
            Route::post('/send', [CustomerAnalyticsController::class, 'sendCampaign'])->name('send');
            Route::post('/quick', [CustomerAnalyticsController::class, 'quickCampaign'])->name('quick');
            Route::get('/{campaign}', [CustomerAnalyticsController::class, 'campaignDetails'])->name('details');
        });
    });

// Language Switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

