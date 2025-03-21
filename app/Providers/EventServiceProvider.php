<?php

namespace App\Providers;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlaceNotificationEvent;
use App\Events\RTOrderPlaceNotificationEvent;
use App\Listeners\OrderPaymentUpdateListener;
use App\Listeners\OrderPlaceNotificationListener;
use App\Listeners\RTOrderPlacedNotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        OrderPaymentUpdateEvent::class => [
            OrderPaymentUpdateListener::class,
        ],

        OrderPlaceNotificationEvent::class => [
            OrderPlaceNotificationListener::class,
        ],

        RTOrderPlaceNotificationEvent::class => [
            RTOrderPlacedNotificationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}