<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    public function store(string $productId): JsonResponse
    {
        if(!Auth::check()){
            throw ValidationException::withMessages(['Please login for add product to wishlist']);
        }

        $productAlreadyExist = Wishlist::where(['product_id' => $productId, 'user_id' => Auth::user()->id])->exists();
        if($productAlreadyExist){
            throw ValidationException::withMessages(['Product already added to wishlist']);
        }

        $wishlist = Wishlist::create([
            'product_id' => $productId,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['status' => 'success', 'message' => 'Product added to wishlist']);
    }
}
