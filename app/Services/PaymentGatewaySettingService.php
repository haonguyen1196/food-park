<?php

namespace App\Services;


use App\Models\PaymentGatewaySetting;
use Cache;

class PaymentGatewaySettingService {
    function getSettings() {
        return Cache::rememberForever('gatewaySettings', function() {
            return PaymentGatewaySetting::pluck('value', 'key')->toArray();
        });
    }

    function setGlobalSettings() {
        $gatewaySettings = $this->getSettings();
       config()->set('gatewaySettings', $gatewaySettings);
    }

    function clearCachedSettings() {
        Cache::forget('gatewaySettings');
    }
}