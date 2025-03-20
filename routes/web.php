<?php

use App\Events\RTOrderPlaceNotificationEvent;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Frontend\AddToCartController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Models\Order;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

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

/* Admin Auth Routes */
Route::group(['middleware' => 'guest'], function() {
    Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
});


Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');
Route::get('load-product-modal/{id}', [FrontendController::class, 'loadProductModal'])->name('load.product.modal');
/** ajax add to cart */
Route::post('add-to-cart', [AddToCartController::class, 'addToCart'])->name('add-to-cart');
Route::get('get-cart-products', [AddToCartController::class, 'getCartProducts'])->name('get-cart-products');
Route::post('remove-cart-product/{rowId}', [AddToCartController::class, 'removeCartProduct'])->name('remove-cart-product');
Route::post('cart-destroy', [AddToCartController::class, 'cartDestroy'])->name('cart.destroy');

/** ajax add to wishlist */
Route::get('wishlist/{productId}', [WishlistController::class, 'store'])->name('wishlist.store');

/** ajax apply coupon */
Route::post('apply-coupon', [AddToCartController::class, 'applyCoupon'])->name('apply-coupon');

/** ajax remove coupon */
Route::post('remove-coupon', [AddToCartController::class, 'removeCoupon'])->name('remove-coupon');

/** cart page */
Route::get('cart', [AddToCartController::class, 'cartPage'])->name('cart-page');

/** update cart quantity product in cart page */
Route::post('cart-update-quantity', [AddToCartController::class, 'updateQuantity'])->name('cart.update.quantity');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    Route::post('address', [DashboardController::class, 'storeAddress'])->name('address.store');
    Route::put('address/{id}', [DashboardController::class, 'updateAddress'])->name('address.update');
    Route::delete('address/{id}', [DashboardController::class, 'destroyAddress'])->name('address.destroy');

    //checkout
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout/delivery-calculator/{id}', [CheckoutController::class, 'deliveryCalculator'])->name('checkout.delivery.calculator');
    Route::post('checkout', [CheckoutController::class, 'checkoutRedirect'])->name('checkout.redirect');

    //payment
    Route::get('payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('make-payment', [PaymentController::class, 'makePayment'])->name('make-payment');

    Route::get("payment-success", [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get("payment-cancel", [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

    //paypal
    Route::get('paypal/payment', [PaymentController::class, 'paypalPayment'])->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

    //stripe
    Route::get('stripe/payment', [PaymentController::class, 'stripePayment'])->name('stripe.payment');
    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');

    //chat
    Route::post('send-message', [ChatController::class, 'sendMessage'])->name('sendMessage.store');
    Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');

    Route::get('test', function () {
        $order = Order::first();
        event(new RTOrderPlaceNotificationEvent($order));
    });
});

require __DIR__.'/auth.php';
