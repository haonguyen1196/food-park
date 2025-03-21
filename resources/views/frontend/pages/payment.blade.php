@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                                                                                                                BREADCRUMB START
                                                                                                                            ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>thanh toán</h1>
                    <ul>
                        <li><a href="index.html">trang chủ</a></li>
                        <li><a href="javascript:;">thanh toán</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                                                                                                                BREADCRUMB END
                                                                                                                            ==============================-->


    <!--============================
                                                                                                                                PAYMENT PAGE START
                                                                                                                            ==============================-->
    <section class="fp__payment_page mt_100 xs_mt_70 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="fp__payment_area">
                        <h2>chọn phương thức thanh toán</h2>
                        <div class="row">
                            @if (config('gatewaySettings.paypal_status') == 1)
                                <div class="col-lg-3 col-6 col-sm-4 col-md-3 wow fadeInUp" data-wow-duration="1s">
                                    <a class="fp__single_payment payment_card" data-name="paypal" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" href="#">
                                        <img src="{{ asset(config('gatewaySettings.paypal_logo')) }}" alt="payment method"
                                            class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif

                            @if (config('gatewaySettings.stripe_status') == 1)
                                <div class="col-lg-3 col-6 col-sm-4 col-md-3 wow fadeInUp" data-wow-duration="1s">
                                    <a class="fp__single_payment payment_card" data-name="stripe" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" href="#">
                                        <img src="{{ config('gatewaySettings.stripe_logo') }}" alt="payment method"
                                            class="img-fluid w-100">
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt_25 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>giỏ hàng</h6>
                        <p>tổng: <span>{{ currencyPosition($subtotal) }}</span></p>
                        <p>phí vận chuyển: <span>{{ currencyPosition($deliveryFee) }}</span></p>
                        <p>giảm giá: <span>{{ currencyPosition($discount) }}</span></p>
                        <p class="total"><span>tổng cộng:</span> <span>{{ currencyPosition($grandTotal) }}</span></p>
                        {{-- <form>
                            <input type="text" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form> --}}
                        {{-- <a class=" common_btn" href=" #">checkout</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--============================
                                                                                                                                PAYMENT PAGE END
                                                                                                                            ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.payment_card').on('click', function() {
                $paymentName = $(this).data('name');

                $.ajax({
                    url: "{{ route('make-payment') }}",
                    type: "POST",
                    data: {
                        payment_method: $paymentName
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr, status, error) {
                        $errors = xhr.responseJSON.errors;
                        if ($errors) {
                            $.each($errors, function(key, value) {


                                toastr.error(value);
                            });
                        }


                    },
                    complete: function() {
                        // hiddenLoader();
                    }
                })
            })
        });
    </script>
@endpush
