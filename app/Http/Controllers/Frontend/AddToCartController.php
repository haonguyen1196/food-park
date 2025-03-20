<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AddToCartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with(['productSizes', 'productOptions'])->findorFail($request->product_id);

        //validate quantity
        if ($request->quantity > $product->quantity) {
            throw ValidationException::withMessages(['Quantity is not available!']);
        }
        try {

            $productSize = $product->productSizes->where('id', $request->product_size)->first();
            $productOptions = $product->productOptions->whereIn('id', $request->product_option);

            $options = [
                'product_size' => [],
                'product_options' => [],
                'product_info' => [
                    'image' => $product->thumb_image,
                    'slug' => $product->slug,
                ]
            ];

            if($productSize !== null) {
                $options['product_size'] = [
                    'id' => $productSize->id,
                    'name' => $productSize->name,
                    'price' => $productSize->price
                ];

            }

            foreach ($productOptions as $option) {
                $options['product_options'][] = [
                    'id' => $option->id,
                    'name' => $option->name,
                    'price' => $option->price
                ];
            }

            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quantity,
                'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
                'weight' => 0,
                'options' => $options
            ]);

            return response([
                'status' => 'success',
                'message' => 'Product added to cart successfully',
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error updating cart quantity: ' . $e->getMessage());
            return response([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function getCartProducts()
    {
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }

    public function removeCartProduct($rowId)
    {
        try {
            Cart::remove($rowId);

            return response([
                'status' => 'success',
                'message' => 'Product removed from cart successfully',
                'cart_total' => cartTotal(),
                'grand_total' => grandCartTotal()
            ], 200);
        }catch (\Exception $e) {
            return response([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    public function cartPage()
    {
        return view('frontend.pages.cart-view');
    }

    public function updateQuantity(Request $request): Response
    {
        $cart = Cart::get($request->rowId);
        $product = Product::findOrFail($cart->id);

        //validate quantity
        if ($request->qty > $product->quantity) {
            throw ValidationException::withMessages(['quantity' => 'Quantity is not available']);
        }

        try {
            Cart::update($request->rowId, $request->qty);

            return response([
                'status' => 'success',
                'message' => 'Cart updated successfully',
                'product_total' => productTotal($request->rowId),
                'cart_total' => cartTotal(),
                'grand_total' => grandCartTotal()
            ], 200);
        }catch (\Exception $e) {
            return response([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    /** clear all cart */
    public function cartDestroy()
    {
        try {
            Cart::destroy();

            session()->forget('coupon');

            return response([
                'status' => 'success',
                'message' => 'Cart cleared successfully',
                'cart_total' => cartTotal(),
                'grand_total' => grandCartTotal()
            ], 200);
        }catch (\Exception $e) {
            return response([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }

    /** apply coupon */
    public function applyCoupon(Request $request)
    {
        $code = $request->code;
        $subtotal = $request->subtotal;

        $coupon = Coupon::where('code', $code)->where('status', 1)->first();

        if ($coupon === null) {
            return response([
            'status' => 'error',
            'message' => 'Invalid coupon code!'
            ], 400);
        }

        if($coupon->quantity <= 0) {
            return response([
                'status' => 'error',
                'message' => 'Coupon is expired!'
            ], 400);
        }

        if($coupon->expire_date < now()) {
            return response([
                'status' => 'error',
                'message' => 'Coupon is expired!'
            ], 400);
        }

        if($coupon->discount_type === 'percent') {
            $discount = number_format(($subtotal * $coupon->discount) / 100, 2);
        } else {
            $discount = number_format($coupon->discount, 2);
        }

        $totalFinal = $subtotal - $discount;

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
        ]);

        return response([
            'status' => 'success',
            'message' => 'Coupon applied successfully',
            'code' => $code,
            'discount' => $discount,
            'totalFinal' => $totalFinal
        ], 200);
    }

    /** remove coupon */
    public function removeCoupon()
    {
        try {
            session()->forget('coupon');

            return response([
                'status' => 'success',
                'message' => 'Coupon removed successfully',
                'cart_total' => cartTotal(),
                'grand_total' => grandCartTotal()
            ], 200);
        }catch (\Exception $e) {
            return response([
                'status' => 'error',
                'message' => 'Something went wrong!'
            ], 500);
        }
    }
}