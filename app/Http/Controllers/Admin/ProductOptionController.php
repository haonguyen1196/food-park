<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        ], [
            'name.required' => 'Product option name field is required.',
            'name.max' => 'Product option name may not be greater than 255 characters.',
            'price.required' => 'Product option price field is required.',
            'price.numeric' => 'Product option price must be a number.',
            'product_id.required' => 'Product option product id field is required.',
            'product_id.integer' => 'Product option product id must be a number.',
        ]);

        /** store product option */
        $productOption = new ProductOption();
        $productOption->name = $request->name;
        $productOption->price = $request->price;
        $productOption->product_id = $request->product_id;
        $productOption->save();

        toastr()->success('Created successfully.');

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
        try{
            /** find product option */
            $productOption = ProductOption::findOrFail($id);

            /** delete product option */
            $productOption->delete();

            /** return json */
            return response()->json([
                'status' => 'success',
                'message' => 'Deleted successfully.',
                'id' => $id
            ]);
        } catch (\Exception $e) {
            /** return json */
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.'
            ]);
        }
    }
}