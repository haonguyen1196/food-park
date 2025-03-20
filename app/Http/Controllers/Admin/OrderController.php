<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveryOrderDataTable;
use App\DataTables\InProcessOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    public function PendingIndex(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending-index');
    }

    public function inProcessIndex(InProcessOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.in-process-index');
    }

    public function deliveryIndex(DeliveryOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivery-index');
    }

    public function declinedIndex(DeclinedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.declined-index');
    }

    public function show($id)
    {
        //update seen 0 to 1 for notification
        OrderPlacedNotification::where('order_id', $id)->update(['seen' => 1]);

        $order = Order::findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    public function destroy($id) : JsonResponse
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

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

    public function orderStatusUpdate(Request $request, $id) : RedirectResponse|Response|JsonResponse
    {
        $request->validate([
            'payment_status' => ['required', 'in:pending,completed'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined'],
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'payment_status' => $request->payment_status,
            'order_status' => $request->order_status,
        ]);

        if($request->ajax()){
            return response()->json(['message' => 'Order status updated!']);
        }else {
            toastr()->success('Status updated successfully');

            return redirect()->back();
        }

    }

    public function getOrderStatus($id): Response
    {
        $order = Order::select('payment_status', 'order_status')->findOrFail($id);

        return response($order);
    }
}
