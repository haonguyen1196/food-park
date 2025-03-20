<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeliveryOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'order.action')
            ->addColumn('user_name', function($query) {
                return $query->user->name;
            })
            ->addColumn('grand_total', function($query) {
                return $query->grand_total.' '.strtoupper($query->currency_name);
            })
            ->addColumn('order_status', function ($query) {
                if($query->order_status == 'delivered'){
                    return '<span class="badge badge-success">Delivered</span>';
                }elseif($query->order_status == 'declined'){
                    return '<span class="badge badge-danger">Declined</span>';
                }else {
                    return '<span class="badge badge-warning">'.$query->order_status.'</span>';
                }
            })
            ->addColumn('payment_status', function ($query) {
                if($query->payment_status == 'completed'){
                    return '<span class="badge badge-success">Completed</span>';
                }elseif($query->payment_status == 'pending'){
                    return '<span class="badge badge-warning">Pending</span>';
                }else {
                    return '<span class="badge badge-danger">'.$query->payment_status.'</span>';
                }
            })
            ->addColumn('date', function($query) {
                return $query->created_at->format('d m Y h:i A');
            })
            ->addColumn('action', function($query) {
                $edit = '<a href="'.route('admin.order.show', $query->id).'" class="btn btn-primary"><i class="far fa-eye"></i></a>';
                $status = '<a href="javascript:;" class="btn btn-warning ml-2 order_status_btn" data-toggle="modal" data-target="#order_model" data-id="'.$query->id.'"><i class="fas fa-truck-loading"></i></a>';
                $delete = '<a href="'.route('admin.order.destroy', $query->id).'" class="btn btn-danger delete-item ml-2"><i class="fas fa-trash-alt"></i></a>';

                return $edit.  $status . $delete;
            })
            ->rawColumns(['action', 'order_status', 'payment_status'])
            ->setRowId('id'); //gán id cho mỗi row tr
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->where('order_status', 'delivered')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingorder-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('invoice_id'),
            Column::make('user_name'),
            Column::make('product_qty'),
            Column::make('grand_total'),
            Column::make('order_status'),
            Column::make('payment_status'),
            Column::make('date'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(200)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingOrder_' . date('YmdHis');
    }
}
