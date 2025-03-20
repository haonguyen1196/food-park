<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
    <div class="fp_dashboard_body">
        <h3>order list</h3>
        <div class="fp_dashboard_order">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr class="t_header">
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <h5>#{{ $order->invoice_id }}</h5>
                                </td>
                                <td>
                                    <p>{{ date('F d,y', strtotime($order->created_at)) }}</p>
                                </td>
                                <td>
                                    @if ($order->order_status == 'pending')
                                        <span class="active">Pending</span>
                                    @elseif($order->order_status == 'in_process')
                                        <span class="active">In Process</span>
                                    @elseif($order->order_status == 'delivered')
                                        <span class="complete">Delivery</span>
                                    @elseif($order->order_status == 'declined')
                                        <span class="cancel">Declined</span>
                                    @endif
                                </td>
                                <td>
                                    <h5>{{ currencyPosition($order->grand_total) }}</h5>
                                </td>
                                <td>
                                    <a class="view_invoice" onclick="viewInvoice('{{ $order->id }}')">View
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach ($orders as $order)
            <div class="fp__invoice invoice_detail_{{ $order->id }}">
                <a class="go_back d-print-none"><i class="fas fa-long-arrow-alt-left"></i> go back</a>
                <div class="fp__track_order d-print-none">
                    <ul>
                        @if ($order->order_status == 'declined')
                            <li
                                class="{{ in_array($order->order_status, ['declined']) ? 'active' : '' }} declined_status">
                                order
                                declined</li>
                        @else
                            <li
                                class="{{ in_array($order->order_status, ['pending', 'in_process', 'delivered']) ? 'active' : '' }}">
                                order pending
                            </li>
                            <li
                                class="{{ in_array($order->order_status, ['in_process', 'delivered']) ? 'active' : '' }}">
                                order in process
                            </li>
                            <li class="{{ in_array($order->order_status, ['delivered']) ? 'active' : '' }}">
                                order delivered
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="fp__invoice_header">
                    <div class="header_address">
                        <h4>invoice to</h4>
                        <p>{{ @$order->userAddress->first_name }} {{ @$order->userAddress->last_name }}</p>

                        <p>{{ $order->address }}</p>
                        <p>{{ @$order->userAddress->phone }}</p>
                        <p>{{ @$order->userAddress->email }}</p>
                    </div>
                    <div class="header_address" style="max-width: 50%">
                        <p><b style="width: 140px">invoice no: </b><span>{{ @$order->invoice_id }}</span></p>
                        <p><b style="width: 140px">payment status:</b> <span>{{ @$order->payment_status }}</span></p>
                        <p><b style="width: 140px">payment method:</b> <span>{{ @$order->payment_method }}</span></p>
                        <p><b style="width: 140px">transaction id:</b> <span>{{ @$order->transaction_id }}</span></p>
                        <p><b style="width: 140px">date:</b>
                            <span>{{ date('d-m-Y', strtotime($order->created_at)) }}</span>
                        </p>
                    </div>
                </div>
                <div class="fp__invoice_body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr class="border_none">
                                    <th class="sl_no">SL</th>
                                    <th class="package">item description</th>
                                    <th class="price">Price</th>
                                    <th class="qnty">Quantity</th>
                                    <th class="total">Total</th>
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
                                        <td class="sl_no">{{ ++$loop->index }}</td>
                                        <td class="package">
                                            <p>{{ $orderItem->product_name }}</p>
                                            @if ($size)
                                                <span class="size">{{ $size->name }}
                                                    ({{ currencyPosition($size->price) }})
                                                </span>
                                            @endif
                                            @if ($options)
                                                @foreach ($options as $option)
                                                    <span class="option">{{ $option->name }}
                                                        ({{ currencyPosition($option->price) }})
                                                    </span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="price">
                                            <b>{{ $orderItem->unit_price }}</b>
                                        </td>
                                        <td class="qnty">
                                            <b>{{ $orderItem->qty }}</b>
                                        </td>
                                        <td class="total">
                                            <b>{{ currencyPosition($productTotal) }}</b>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="package" colspan="3">
                                        <b>sub total</b>
                                    </td>
                                    <td class="qnty">
                                        <b>-</b>
                                    </td>
                                    <td class="total">
                                        <b>{{ currencyPosition($order->subtotal) }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="package coupon" colspan="3">
                                        <b>(-) Discount coupon</b>
                                    </td>
                                    <td class="qnty">
                                        <b></b>
                                    </td>
                                    <td class="total coupon">
                                        <b>{{ currencyPosition($order->discount) }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="package coast" colspan="3">
                                        <b>(+) Shipping Cost</b>
                                    </td>
                                    <td class="qnty">
                                        <b></b>
                                    </td>
                                    <td class="total coast">
                                        <b>{{ currencyPosition($order->delivery_charge) }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="package" colspan="3">
                                        <b>Total Paid</b>
                                    </td>
                                    <td class="qnty">
                                        <b></b>
                                    </td>
                                    <td class="total">
                                        <b>{{ currencyPosition($order->grand_total) }}</b>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <a class="print_btn common_btn d-print-none" href="javascript:;"
                    onclick="printInvoice('{{ $order->id }}')">
                    <i class="far fa-print"></i>
                    print PDF
                </a>

            </div>
        @endforeach
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>

    <script>
        function viewInvoice(id) {
            $(".invoice_detail_" + id).fadeIn();
            $(".fp_dashboard_order").fadeOut();
        }

        function printInvoice(id) {
            $('.invoice_detail_' + id).printThis({
                importCSS: true, // Import các kiểu CSS từ trang hiện tại
            });
        }
    </script>
@endpush
