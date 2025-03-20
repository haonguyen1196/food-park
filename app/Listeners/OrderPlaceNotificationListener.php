<?php

namespace App\Listeners;

use App\Events\OrderPlaceNotificationEvent;
use App\Mail\OrderPlace;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class OrderPlaceNotificationListener
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
    public function handle(OrderPlaceNotificationEvent $event): void
    {
        $oderId = $event->orderId;

        $order = Order::with('user')->find($oderId);
        Mail::send(new OrderPlace($order));
    }
}
