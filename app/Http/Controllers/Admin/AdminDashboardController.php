<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPlacedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index() :View
    {
        return view('admin.dashboard.index');
    }

    public function clearOrderNotification()
    {
        //set all seen 0 to 1 for notification
        OrderPlacedNotification::where('seen', 0)->update(['seen' => 1]);

        return redirect()->back();
    }
}