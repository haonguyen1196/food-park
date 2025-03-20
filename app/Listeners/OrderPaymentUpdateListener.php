<?php

namespace App\Listeners;

use App\Events\OrderPaymentUpdateEvent;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderPaymentUpdateListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPaymentUpdateEvent $event): void
    {
        $orderId = session()->get('order_id');
        $order = Order::find($orderId);
        $order->payment_method = $event->paymentMethod;
        $order->payment_status = $event->paymentInfo['status'];
        $order->payment_approve_date = now()->format('Y-m-d H:i:s');
        $order->transaction_id = $event->paymentInfo['transaction_id'];
        $order->currency_name = $event->paymentInfo['currency'];

        $order->save();
    }
}
