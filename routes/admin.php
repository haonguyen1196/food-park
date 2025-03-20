<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Models\ProductGallery;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /** profile routes */
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    /** slider routes */
    Route::resource('sliders', SliderController::class);

    /** daily offer routes */
    Route::get('daily-offer/search-product', [DailyOfferController::class, 'searchProduct'])->name('daily-offer.search-product');
    Route::resource('daily-offer', DailyOfferController::class);

    /** why choose us routes */
    Route::put('why-choose-title-update', [WhyChooseUsController::class, 'updateTitle'])->name('why-choose-title-update');
    Route::resource('why-choose-us', WhyChooseUsController::class);

    /** product category route */
    Route::resource('category', CategoryController::class);

    /** product route */
    Route::resource('product', ProductController::class);

    /** product route */
    Route::get('product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery.show-index');
    Route::resource('product-gallery', ProductGalleryController::class);

    /** product size route */
    Route::get('product-size/{product}', [ProductSizeController::class, 'index'])->name('product-size.show-index');
    Route::resource('product-size', ProductSizeController::class);

    /** product option route */
    Route::resource('product-option', ProductOptionController::class);

    /** coupon route */
    Route::resource('coupon', CouponController::class);

    /** delivery area route */
    Route::resource('delivery-area', DeliveryAreaController::class);

    /** order */
    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::get('order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('order/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
    Route::delete('order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');

    Route::get('order/status/{id}', [OrderController::class, 'getOrderStatus'])->name('order.status');
    Route::put('order/status-update/{id}', [OrderController::class, 'orderStatusUpdate'])->name('order.status-update');

    //order status page
    Route::get('order-pending', [OrderController::class, 'PendingIndex'])->name('order.pending-index');
    Route::get('order-in-process', [OrderController::class, 'inProcessIndex'])->name('order.in-process-index');
    Route::get('order-delivery', [OrderController::class, 'deliveryIndex'])->name('order.delivery-index');
    Route::get('order-declined', [OrderController::class, 'declinedIndex'])->name('order.declined-index');


    /** order placed notification */
    Route::get('clear-order-notification', [AdminDashboardController::class, 'clearOrderNotification'])->name('clear-order-notification');

    /** payment gateway setting */
    Route::get('payment-gateway-setting', [PaymentGatewaySettingController::class, 'index'])->name('payment-gateway-setting.index');
    Route::put('paypal-setting', [PaymentGatewaySettingController::class, 'updatePaypalSetting'])->name('paypal-setting.update');
    Route::put('stripe-setting', [PaymentGatewaySettingController::class, 'updateStripeSetting'])->name('stripe-setting.update');
    Route::put('razorpay-setting', [PaymentGatewaySettingController::class, 'updateRazorpaySetting'])->name('razorpay-setting.update');

    /** chat route */
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');

    /** setting route */
    Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('general-setting', [SettingController::class, 'updateGeneralSetting'])->name('general-setting.update');
    Route::put('pusher-setting', [SettingController::class, 'updatePusherSetting'])->name('pusher-setting.update');

});