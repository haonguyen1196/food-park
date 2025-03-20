<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductSize;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $productId): View
    {
        $product = Product::findOrFail($productId);
        $productSizes = ProductSize::where('product_id', $productId)->latest()->get();
        $productOptions = ProductOption::where('product_id', $productId)->latest()->get();
        return view('admin.product.product-size.index', compact('product', 'productSizes', 'productOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** validate form */
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'product_id' => ['required', 'integer'],
        ]);

        /** create product size */
        $productSize = new ProductSize();
        $productSize->name = $request->name;
        $productSize->price = $request->price;
        $productSize->product_id = $request->product_id;
        $productSize->save();

        toastr()->success('Created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $productSize = ProductSize::findOrFail($id);
            $productSize->delete();

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Deleted successfully',
                'id' => $id
            ]);
        } catch (\Exception $e) {
            // return response
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }
}
