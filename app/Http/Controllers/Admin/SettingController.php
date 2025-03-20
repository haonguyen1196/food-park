<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(): View
    {
        /** pluck key */
        $settings = Setting::pluck('value', 'key');

        return view('admin.setting.index', compact('settings'));
    }

    public function updateGeneralSetting(Request $request)
    {
        /** validate form */
        $validateData = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_default_currency' => ['required', 'max:4'],
            'site_currency_icon' => ['required', 'max:4'],
            'site_currency_icon_position' => ['required', 'max:255']
        ]);

        foreach ($validateData as $key => $value) {
            //update or create setting
            $setting = Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        //forget cache settings
        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated successfully');

        return redirect()->back();
    }

    public function updatePusherSetting(Request $request): RedirectResponse
    {
        /** validate form */
        $validateData = $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required']
        ]);

        foreach ($validateData as $key => $value) {
            //update or create setting
            $setting = Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        //forget cache settings
        $settingsService = app(SettingsService::class);
        $settingsService->clearCachedSettings();

        toastr()->success('Updated successfully');

        return redirect()->back();
    }
}