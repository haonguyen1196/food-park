<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(string $id): View
    {
        $product = Product::findOrFail($id);
        $images = ProductGallery::where('product_id', $id)->latest()->get();
        return view('admin.product.gallery.index', compact('product', 'images'));
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
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'product_id' => ['required', 'integer'],
        ]);

        /** create image path */
        $imagePath = $this->uploadImage($request, 'image');

        $productGallery = new ProductGallery();
        $productGallery->image = $imagePath;
        $productGallery->product_id = $request->product_id;
        $productGallery->save();

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
            $productGallery = ProductGallery::findOrFail($id);
            /** delete image */
            $this->removeImage($productGallery->image);
            $productGallery->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Deleted successfully',
                'id' => $id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }
}