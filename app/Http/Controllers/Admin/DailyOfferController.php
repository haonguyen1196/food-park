<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DailyOfferDataTable;
use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyOfferDataTable $dataTable): View|JsonResponse
    {
        return $dataTable->render("admin.daily-offer.index");
    }

    public function searchProduct(Request $request): Response
    {
        $product = Product::select('id', 'name', 'thumb_image')->where('name', 'like', '%' . $request->search . '%')->get();
        return response($product);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.daily-offer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the request
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        DailyOffer::create($data);

        toastr()->success('Created successfully!');

        return redirect()->route('admin.daily-offer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dailyOffer = DailyOffer::with('product')->findOrFail($id);
        return view('admin.daily-offer.edit', compact('dailyOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validate the request
        $data = $request->validate([
            'product_id' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        $dailyOffer = DailyOffer::findOrFail($id);
        $dailyOffer->update($data);

        toastr()->success('Updated successfully!');

        return redirect()->route('admin.daily-offer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dailyOffer = DailyOffer::findOrFail($id);

            $dailyOffer->delete();

            return response(['status' => 'success', 'message' => 'Deleted successfully!', 'id' => $id]);
        } catch (\Exception $e) {
            //response json
            return response(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }
}