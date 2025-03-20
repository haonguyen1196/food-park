<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Models\Address;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\Wishlist;
use Flasher\Laravel\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index(Request $request): View
    {
        $open = $request->query('open');
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        $userAddress = Address::where('user_id', auth()->id())->get();
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        $wishlists = Wishlist::where('user_id', auth()->id())->latest()->get();
        return view('frontend.dashboard.index', compact('deliveryAreas', 'userAddress', 'orders', 'open', 'wishlists'));
    }

    public function storeAddress(AddressCreateRequest $request): RedirectResponse
    {
        Address::create([
            'user_id' => auth()->id(),
            'delivery_area_id' => $request->delivery_area_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'type' => $request->type,
        ]);

        toastr()->success('Created successfully');

        return redirect()->route('checkout.index');
    }

    public function updateAddress(Request $request)
    {
        $address = Address::findOrFail($request->id);
        $address->update([
            'delivery_area_id' => $request->delivery_area_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'type' => $request->type,
        ]);

        toastr()->success('Updated successfully');

        return redirect()->back();
    }

    public function destroyAddress($id)
    {
        $address = Address::findOrFail($id);

        if($address->user_id != auth()->id()) {
            //response ajax
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);

        }
        $address->delete();
        //response ajax
        return response()->json([
            'status' => 'success',
            'message' => 'Deleted successfully',
        ], 200);
    }
}
