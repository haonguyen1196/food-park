<?php

namespace App\Listeners;

use App\Events\RTOrderPlaceNotificationEvent;
use App\Models\OrderPlacedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RTOrderPlacedNotificationListener
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
    public function handle(RTOrderPlaceNotificationEvent $event): void
    {
        OrderPlacedNotification::create([
            'order_id' => $event->orderId,
            'message' => $event->message,
        ]);
    }
}