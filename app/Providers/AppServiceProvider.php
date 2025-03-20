<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $keys = ['pusher_key', 'pusher_secret', 'pusher_app_id', 'pusher_cluster'];
        $pusherConfig = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();

        config(['broadcasting.connections.pusher.key' => $pusherConfig['pusher_key']]);
        config(['broadcasting.connections.pusher.secret' => $pusherConfig['pusher_secret']]);
        config(['broadcasting.connections.pusher.app_id' => $pusherConfig['pusher_app_id']]);
        config(['broadcasting.connections.pusher.options.cluster' => $pusherConfig['pusher_cluster']]);
    }
}