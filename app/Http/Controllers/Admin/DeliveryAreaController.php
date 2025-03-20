<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeliveryAreaDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryAreaCreateRequest;
use App\Models\DeliveryArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DeliveryAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DeliveryAreaDataTable $dataTable)
    {
        return $dataTable->render('admin.delivery-area.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.delivery-area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryAreaCreateRequest $request)
    {
        DeliveryArea::create($request->validated());

        toastr()->success('Created successfully!');

        return redirect()->route('admin.delivery-area.index');
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
        $deliveryArea = DeliveryArea::findOrFail($id);

        return view('admin.delivery-area.edit', compact('deliveryArea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliveryAreaCreateRequest $request, string $id)
    {
        $deliveryArea = DeliveryArea::findOrFail($id);
        $deliveryArea->update($request->validated());

        toastr()->success('Updated successfully!');

        return redirect()->route('admin.delivery-area.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $deliveryArea = DeliveryArea::findOrFail($id);
            $deliveryArea->delete();

            //response json
            return response()->json([
                'status' => 'success',
                'message' => 'Deleted successfully',
                'id' => $id
            ]);
        } catch (\Exception $e) {
            //notification
            toastr()->error('Something went wrong');
        }
    }
}