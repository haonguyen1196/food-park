<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $userAddress = Address::where('user_id', auth()->id())->get();

        $deliveryAreas = DeliveryArea::where('status', 1)->get();

        return view('frontend.pages.checkout', compact('userAddress', 'deliveryAreas'));
    }

    public function deliveryCalculator($id)
    {
        try {
            $address = Address::find($id);
            $deliveryFee = $address->deliveryArea?->delivery_fee;

            $grandTotal = grandCartTotal() + $deliveryFee;

            return response()->json([
                'status' => 'success',
                'message' => 'Delivery fee calculated',
                'delivery_fee' => currencyPosition($deliveryFee),
                'grand_total' => currencyPosition($grandTotal)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function checkoutRedirect(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer'
            ]);

            $address = Address::with('deliveryArea')->findOrFail($request->id);
            $addressSelect = $address->address.', Area: '.$address->deliveryArea?->area_name;

            session()->put('address', $addressSelect);
            session()->put('address_id', $address->id);
            session()->put('delivery_fee', $address->deliveryArea?->delivery_fee);

            return response()->json([
                'status' => 'success',
                'redirect_url' => route('payment.index'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }
}