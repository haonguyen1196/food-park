/@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order Preview</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Invoice</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Deliver To:</strong><br>
                                        <strong>Name: </strong>{{ @$order->userAddress->first_name }}
                                        {{ @$order->userAddress->last_name }}<br />
                                        <strong>Phone: </strong>{{ @$order->userAddress->phone }}<br />
                                        <strong>Address: </strong>{{ $order->userAddress->address }}<br />
                                        <strong>Area: </strong>{{ $order->userAddress->deliveryArea->area_name }}<br />
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{ date('F d, y / H:i', strtotime($order->created_at)) }}<br><br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Method: </strong>{{ $order->payment_method }}<br>
                                        <strong>Payment Status: </strong>
                                        @if ($order->payment_status == 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($order->payment_status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">{{ $order->payment_status }}</span>
                                        @endif
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Status: </strong><br>
                                        @if ($order->order_status == 'delivered')
                                            <span class="badge badge-success">Delivered</span>
                                        @elseif($order->order_status == 'declined')
                                            <span class="badge badge-danger">Declined</span>
                                        @else
                                            <span class="badge badge-warning">{{ $order->order_status }}</span>
                                        @endif
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Item</th>
                                        <th>Size & Optional</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>

                                    @foreach ($order->orderItem as $orderItem)
                                        @php
                                            $size = json_decode($orderItem->product_size);
                                            $options = json_decode($orderItem->product_option);

                                            $qty = $orderItem->qty;
                                            $unitPrice = $orderItem->unit_price;
                                            $sizePrice = $size ? $size->price : 0;
                                            $optionPrice = 0;
                                            foreach ($options as $option) {
                                                $optionPrice += $option->price;
                                            }

                                            $productTotal = ($unitPrice + $sizePrice + $optionPrice) * $qty;
                                        @endphp
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $orderItem->product_name }}</td>
                                            <td>
                                                @if ($size)
                                                    <b>{{ @$size->name }}
                                                        ({{ currencyPosition($size->price) }})
                                                    </b>
                                                @endif

                                                @if ($options)
                                                    <br>
                                                    options:
                                                    <br>
                                                    @foreach ($options as $option)
                                                        {{ $option->name }}
                                                        ({{ currencyPosition($option->price) }})
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </td>


                                            <td class="text-center">{{ currencyPosition($orderItem->unit_price) }}</td>
                                            <td class="text-center">{{ $orderItem->qty }}</td>
                                            <td class="text-right">{{ currencyPosition($productTotal) }}</td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="col-md-4 d-print-none">
                                        <form action="{{ route('admin.order.status-update', $order->id) }}" method="POST">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group">
                                                <label for="">Payment status</label>
                                                <select class="form-control" name="payment_status" id="">
                                                    <option @selected($order->payment_status === 'pending') value="pending">Pending</option>
                                                    <option @selected($order->payment_status === 'completed') value="completed">Completed
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Order status</label>
                                                <select class="form-control" name="order_status" id="">
                                                    <option @selected($order->order_status === 'pending') value="pending">Pending</option>
                                                    <option @selected($order->order_status === 'in_process') value="in_process">In process
                                                    </option>
                                                    <option @selected($order->order_status === 'delivery') value="delivery">Delivery</option>
                                                    <option @selected($order->order_status === 'declined') value="declined">declined</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-info">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->subtotal) }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->delivery_charge) }}
                                        </div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Discount</div>
                                        <div class="invoice-detail-value">{{ currencyPosition($order->discount) }}
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ currencyPosition($order->grand_total) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    {{-- <div class="float-lg-left mb-lg-0 mb-3">
                        <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process
                            Payment</button>
                        <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
                    </div> --}}
                    <button class="btn btn-warning btn-icon icon-left" id="print_btn"><i class="fas fa-print"></i>
                        Print</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#print_btn').click(function() {
                $('.invoice-print').printThis({
                    importCSS: true, // Import các kiểu CSS từ trang hiện tại
                    loadCSS: "{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}" // Đường dẫn đến tệp CSS Bootstrap
                });
            });
        });
    </script>
@endpush
