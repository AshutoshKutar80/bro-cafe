<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Partner\DashboardController as PartnerDashboard;
use App\Http\Controllers\Partner\OrderController as PartnerOrderController;
use App\Http\Controllers\Partner\LocationController as PartnerLocationController;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/product/{slug}', [MenuController::class, 'show'])->name('product.show');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/otp-verify', [OtpController::class, 'show'])->name('otp.verify.form');
    Route::post('/otp-verify', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/otp-resend', [OtpController::class, 'resend'])->name('otp.resend');
    Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp'])->name('password.send');
    Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.reset');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Customer (auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::post('/checkout/validate-coupon', [CheckoutController::class, 'validateCoupon'])->name('checkout.coupon');
    Route::get('/order-success/{orderNumber}', [CustomerOrderController::class, 'success'])->name('order.success');
    Route::get('/track/{orderNumber}', [CustomerOrderController::class, 'track'])->name('order.track');
    Route::get('/order/{orderNumber}', [CustomerOrderController::class, 'show'])->name('order.show');
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/theme', [AccountController::class, 'updateTheme'])->name('account.theme');
    Route::post('/account/address', [AccountController::class, 'storeAddress'])->name('account.address.store');
    Route::delete('/account/address/{id}', [AccountController::class, 'deleteAddress'])->name('account.address.delete');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index','show']);
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('orders/{order}/assign', [AdminOrderController::class, 'assignPartner'])->name('orders.assign');
    Route::resource('partners', PartnerController::class);
    Route::resource('coupons', CouponController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

// Partner
Route::middleware(['auth', 'role:partner'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/', [PartnerDashboard::class, 'index'])->name('dashboard');
    Route::get('order/{delivery}', [PartnerOrderController::class, 'show'])->name('order.show');
    Route::post('order/{delivery}/status', [PartnerOrderController::class, 'updateStatus'])->name('order.status');
    Route::post('toggle-online', [PartnerOrderController::class, 'toggleOnline'])->name('toggle.online');
    Route::post('location', [PartnerLocationController::class, 'store'])->name('location.store');
});