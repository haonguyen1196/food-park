@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        BREADCRUMB START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Giỏ hàng</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">trang chủ</a></li>
                        <li><a href="javascript:;">Giỏ hàng</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        BREADCRUMB END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ==============================-->


    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        CART VIEW START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table id="cartTable">
                                <tbody>
                                    <tr>
                                        <th class="fp__pro_img">
                                            Hình ảnh
                                        </th>

                                        <th class="fp__pro_name">
                                            chi tết
                                        </th>

                                        <th class="fp__pro_status">
                                            giá
                                        </th>

                                        <th class="fp__pro_select">
                                            số lượng
                                        </th>

                                        <th class="fp__pro_tk">
                                            tổng
                                        </th>

                                        <th class="fp__pro_icon">
                                            <a class="clear_all" href="javascript:;">xóa tất cả</a>
                                        </th>
                                    </tr>
                                    @foreach (Cart::content() as $item)
                                        <tr>
                                            <td class="fp__pro_img"><img
                                                    src="{{ asset($item->options['product_info']['image']) }}"
                                                    alt="{{ $item->name }}" class="img-fluid w-100">
                                            </td>

                                            <td class="fp__pro_name">
                                                <a
                                                    href="{{ route('product.show', $item->options['product_info']['slug']) }}">{{ $item->name }}</a>
                                                @if (@$item->options['product_size']['name'])
                                                    <span>{{ @$item->options['product_size']['name'] }}
                                                        ({{ @currencyPosition($item->options['product_size']['price']) }})
                                                    </span>
                                                @endif

                                                @foreach ($item->options['product_options'] as $option)
                                                    <p>{{ $option['name'] }} {{ currencyPosition($option['price']) }}</p>
                                                @endforeach
                                            </td>

                                            <td class="fp__pro_status">
                                                <h6>{{ currencyPosition($item->price) }}</h6>
                                            </td>

                                            <td class="fp__pro_select">
                                                <div class="quentity_btn">
                                                    <button class="btn btn-danger decrement"><i
                                                            class="fal fa-minus"></i></button>
                                                    <input type="text" data-id={{ $item->rowId }} class="quantity"
                                                        value="{{ $item->qty }}" readonly>
                                                    <button class="btn btn-success increment"><i
                                                            class="fal fa-plus"></i></button>
                                                </div>
                                            </td>

                                            <td class="fp__pro_tk">
                                                <h6 class="cart_product_total">
                                                    {{ currencyPosition(productTotal($item->rowId)) }}</h6>
                                            </td>

                                            <td class="fp__pro_icon">
                                                <a href="javascript:;" class="remove_product_cart"
                                                    data-id="{{ $item->rowId }}"><i class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (Cart::count() == 0)
                                        <tr>
                                            <td colspan="6" class="w-100 d-inline">Giỏ hàng trống</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>Tổng giỏ hàng</h6>
                        <p>tổng: <span id="subtotal">{{ currencyPosition(cartTotal()) }}</span></p>
                        <p>phí vận chuyển: <span>$0</span></p>
                        <p>giảm giá: <span id="discount">{{ currencyPosition(session('coupon')['discount'] ?? 0) }}</span>
                        </p>
                        <p class="total"><span>tổng cộng:</span> <span
                                id="total_final">{{ currencyPosition(session('coupon') ? cartTotal() - session('coupon')['discount'] : cartTotal()) }}</span>
                        </p>
                        <form id="coupon_form">
                            <input type="text" id="coupon_code" placeholder="Coupon Code">
                            <button type="submit">Nhập</button>
                        </form>
                        <!-- appied coupon -->
                        <div class="coupon_card">
                            @if (session('coupon'))
                                <div class="card mt-2">
                                    <div class="m-3">
                                        <span><b>Đã nhập mã giảm giá: {{ session()->get('coupon')['code'] }}</b></span>
                                        <span>
                                            <button class="remove_coupon"><i class="far fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <a class="common_btn" href="{{ route('checkout.index') }}">thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                    CART VIEW END
                                                                                                                                                                                                                                                                                                                                                                                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.increment').on('click', function() {
                $inputField = $(this).siblings('.quantity');
                $newQty = parseInt($inputField.val()) + 1;

                $rowId = $inputField.data('id');
                cartUpdateQty($rowId, $newQty, function(response) {
                    if (response.status === 'success') {
                        // Cập nhật giá trị của input và tổng giá sản phẩm
                        $inputField.val($newQty);
                        $inputField.closest('tr').find('.cart_product_total').text(
                            '{{ currencyPosition(':productTotal') }}'
                            .replace(':productTotal', response.product_total));
                    }
                });
            })

            $('.decrement').on('click', function() {
                $inputField = $(this).siblings('.quantity');
                if (parseInt($inputField.val()) > 1) {
                    $newQty = parseInt($inputField.val()) - 1;

                    $rowId = $inputField.data('id');
                    cartUpdateQty($rowId, $newQty, function(response) {
                        if (response.status === 'success') {
                            // Cập nhật giá trị của input và tổng giá sản phẩm
                            $inputField.val($newQty);
                            $inputField.closest('tr').find('.cart_product_total').text(
                                '{{ currencyPosition(':productTotal') }}'
                                .replace(':productTotal', response.product_total));
                        }
                    });
                }

            })

            /** cart update quantity */
            function cartUpdateQty($rowId, $qty, callback = null) {
                $.ajax({
                    url: "{{ route('cart.update.quantity') }}",
                    type: "POST",
                    data: {
                        rowId: $rowId,
                        qty: $qty
                    },
                    beforeSend: function() {
                        // showLoader();
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#subtotal').text('{{ currencyPosition(':cartTotal') }}'.replace(
                                ':cartTotal', response.cart_total));
                            $('#total_final').text('{{ currencyPosition(':grandCardTotal') }}'.replace(
                                ':grandCardTotal', response.grand_total));
                            toastr.success(response.message);

                            if (callback && typeof callback === 'function') {
                                callback(response);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        // hiddenLoader();
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        // hiddenLoader();
                    }
                });
            }

            /** remove product from cart */
            $('.remove_product_cart').on('click', function() {
                $rowId = $(this).data('id');
                removeProductCart($rowId);

                $(this).closest('tr').remove();
            })

            function removeProductCart($rowId) {
                $.ajax({
                    url: "{{ route('remove-cart-product', ':rowId') }}".replace(':rowId', $rowId),
                    type: "POST",
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#subtotal').text('{{ currencyPosition(':cartTotal') }}'.replace(
                                ':cartTotal', response.cart_total));
                            $('#total_final').text('{{ currencyPosition(':grandCardTotal') }}'.replace(
                                ':grandCardTotal',
                                response.grand_total));
                            s
                            toastr.success(response.message);
                            updateSidebarCart();
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    }
                });
            }

            /** clear all cart */
            $('.clear_all').on('click', function() {
                $.ajax({
                    url: "{{ route('cart.destroy') }}",
                    type: "POST",
                    success: function(response) {
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            updateSidebarCart();

                            // remove all product from cart table
                            $('#cartTable tr:not(:first)').remove();

                            //add empty cart message
                            $('#cartTable').append(
                                '<tr><td colspan="6" class="w-100 d-inline">Empty Cart</td></tr>'
                            );

                            $('#subtotal').text('{{ currencyPosition(':cartTotal') }}'.replace(
                                ':cartTotal', response.cart_total));
                            $('#total_final').text('{{ currencyPosition(':grandCardTotal') }}'
                                .replace(
                                    ':grandCardTotal',
                                    response.grand_total));
                            $('#discount').text('{{ currencyPosition('0') }}');
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    }
                });
            })

            $('#coupon_form').on('submit', function(e) {
                e.preventDefault();
                $code = $('#coupon_code').val();
                $subtotal = '{{ cartTotal() }}';

                couponApply($code, $subtotal);
            })


            /** apply coupon */
            function couponApply($code, $subtotal) {
                $.ajax({
                    url: '{{ route('apply-coupon') }}',
                    type: 'POST',
                    data: {
                        code: $code,
                        subtotal: $subtotal
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#discount').text('{{ currencyPosition(':discount') }}'.replace(
                                ':discount', response.discount));
                            $('#total_final').text('{{ currencyPosition(':total') }}'.replace(
                                ':total', response.totalFinal));

                            $couponHtml = `<div class="card mt-2">
                                <div class="m-3">
                                    <span><b>Applied Coupon: ${response.code}</b></span>
                                    <span>
                                        <button class="remove_coupon"><i class="far fa-times"></i></button>
                                    </span>
                                </div>`;

                            $('.coupon_card').html($couponHtml);

                            toastr.success(response.message);
                            updateSidebarCart(function() {
                                hiddenLoader();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                        hiddenLoader();
                    }
                });

            }

            /** remove coupon */
            $(document).on('click', '.remove_coupon', function() {
                removeCoupon();
            });

            function removeCoupon() {
                $.ajax({
                    url: '{{ route('remove-coupon') }}',
                    type: 'POST',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#discount').text('{{ currencyPosition('0') }}');
                            $('#total_final').text('{{ currencyPosition(':total') }}'.replace(
                                ':total',
                                response.grand_total));
                            $('.coupon_card').html('');
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    }
                });
            }
        });
    </script>
@endpush
