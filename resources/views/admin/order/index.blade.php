@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Orders</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Orders</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="order_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="order_status_form">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="">Payment status</label>
                            <select class="form-control payment_status" name="payment_status" id="">
                                <option value="pending">Pending</option>
                                <option value="completed">Completed
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Order status</label>
                            <select class="form-control order_status" name="order_status" id="">
                                <option value="pending">Pending</option>
                                <option value="in_process">In process
                                </option>
                                <option value="delivered">Delivered</option>
                                <option value="declined">Declined</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary order_status_submit">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        $(document).ready(function() {
            let orderId = '';
            $(document).on('click', '.order_status_btn', function() {
                let id = $(this).data('id');
                orderId = id;
                let paymentStatus = $('.payment_status option');
                let orderStatus = $('.order_status option');

                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.order.status', ':id') }}'.replace(":id", id),
                    beforeSend: function() {
                        $('.order_status_submit').attr('disabled', 'disabled');
                    },
                    success: function(response) {
                        //trước khi selected thì gỡ selected
                        paymentStatus.each(function() {
                            $(this).removeAttr('selected');
                        });
                        paymentStatus.each(function() {
                            if ($(this).val() == response.payment_status) {
                                $(this).attr('selected', 'selected');
                            }
                        });

                        //trước khi selected thì gỡ selected
                        orderStatus.each(function() {
                            $(this).removeAttr('selected');
                        });
                        orderStatus.each(function() {
                            if ($(this).val() == response.order_status) {
                                $(this).attr('selected', 'selected');
                            }
                        });

                        $('.order_status_submit').removeAttr('disabled');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            })

            //handle update order status
            $('.order_status_form').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    method: 'PUT',
                    data: $(this).serialize(),
                    url: '{{ route('admin.order.status-update', ':id') }}'.replace(":id", orderId),
                    success: function(response) {
                        $('#order_model').modal('hide');
                        toastr.success(response.message);
                        //reload datatable
                        $('#order-table').DataTable().draw();
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseJSON.message);
                    }
                })
            });
        })
    </script>
@endpush
