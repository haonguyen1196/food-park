@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                                                                                                                                                                                    BREADCRUMB START
                                                                                                                                                                                                ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Thanh toán</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">trang chủ</a></li>
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
                                                                                                                                                                                                    CHECK OUT PAGE START
                                                                                                                                                                                                ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__checkout_form">
                        <div class="fp__check_form">
                            <h5>chọn địa chỉ <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i
                                        class="far fa-plus"></i> thêm địa chỉ</a></h5>

                            <div class="fp__address_modal">
                                <div class="modal fade" id="address_modal" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="address_modalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="address_modalLabel">thêm địa chỉ mới
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="fp_dashboard_new_address d-block">
                                                    <form method="POST" action="{{ route('address.store') }}">
                                                        <div class="row">
                                                            @csrf
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="fp__check_single_form">
                                                                    <select class="nice-select" name="delivery_area_id">
                                                                        <option value="">chọn khu vực giao hàng
                                                                        </option>
                                                                        @foreach ($deliveryAreas as $deliveryArea)
                                                                            <option value="{{ $deliveryArea->id }}">
                                                                                {{ $deliveryArea->area_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="text" placeholder="Họ"
                                                                        name="first_name">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="text" placeholder="Tên"
                                                                        name="last_name">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="text" placeholder="Số điện thoại *"
                                                                        name="phone">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="fp__check_single_form">
                                                                    <input type="email" placeholder="Email *"
                                                                        name="email">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="fp__check_single_form">
                                                                    <textarea cols="3" rows="4" placeholder="Địa chỉ" name="address"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="fp__check_single_form check_area">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="type" id="flexRadioDefault1"
                                                                            value="home">
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault1">
                                                                            Nhà
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="type" id="flexRadioDefault2"
                                                                            value="office">
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault2">
                                                                            Văn phòng
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex">
                                                                <button style="width: 200px" type="button"
                                                                    class="common_btn cancel_new_address"
                                                                    data-bs-dismiss="modal">hủy</button>
                                                                <button style="width: 200px; margin-left: 8px"
                                                                    type="submit" class="common_btn">lưu
                                                                    địa chỉ</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($userAddress as $address)
                                    <div class="col-md-6">
                                        <div class="fp__checkout_single_address">
                                            <div class="form-check">
                                                <input class="form-check-input v_address" value="{{ $address->id }}"
                                                    type="radio" name="address" id="home">
                                                <label class="form-check-label" for="home">
                                                    <span class="icon">
                                                        <i
                                                            class="{{ $address->type === 'home' ? 'fas fa-home' : 'far fa-car-building' }}"></i>
                                                        {{ $address->type === 'home' ? 'home' : 'office' }}
                                                    </span>
                                                    <span class="address">{{ $address->address }},
                                                        {{ $address->deliveryArea->area_name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>

                            {{-- <form>
                                <div class="row">
                                    <div class="col-12">
                                        <h5>billing address</h5>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="Company Name (Optional)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <select id="select_js3">
                                                <option value="">select country</option>
                                                <option value="">bangladesh</option>
                                                <option value="">nepal</option>
                                                <option value="">japan</option>
                                                <option value="">korea</option>
                                                <option value="">thailand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="Street Address *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="Apartment, suite, unit, etc. (optional)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="Town / City *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="State *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="Zip *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="text" placeholder="Phone *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="fp__check_single_form">
                                            <input type="email" placeholder="Email *">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="fp__check_single_form">
                                            <h5>Additional Information</h5>
                                            <textarea cols="3" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="fp__cart_list_footer_button">
                        <h6>Tổng giỏ hàng</h6>
                        <p>tổng: <span>{{ currencyPosition(cartTotal()) }}</span></p>
                        <p>Phí giao hàng: <span class='delivery_fee'>$00.00</span></p>
                        <p>giảm giá: <span>{{ currencyPosition(session()->get('coupon')['discount'] ?? 0) }}</span></p>
                        <p class="total"><span>tổng cộng:</span> <span
                                class="grand_total">{{ currencyPosition(grandCartTotal()) }}</span></p>
                        {{-- <form>
                            <input type="text" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form> --}}
                        <a class="common_btn" href="javascript:;" id="procced_btm_button">Tiến hành thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                    CHECK OUT PAGE END
                                                                                                                                                                                                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.v_address').on('change', function() {
                $('.v_address').not(this).prop('checked', false);
                let addressId = $(this).val();

                $.ajax({
                    url: "{{ route('checkout.delivery.calculator', ':id') }}".replace(':id',
                        addressId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('.delivery_fee').text(response.delivery_fee);
                            $('.grand_total').text(response.grand_total);
                        }
                    },
                    error: function(xhr, status, error) {
                        let messageAlert = xhr.responseJSON.message;
                        toastr.error(messageAlert);
                    },
                    complete: function() {
                        hiddenLoader();
                    }

                });
            })

            $('#procced_btm_button').on('click', function() {
                $address = $('.v_address:checked');

                if ($address.length == 0) {
                    toastr.error('Please select an address');
                    return;
                }

                $.ajax({
                    url: '{{ route('checkout.redirect') }}',
                    type: "POST",
                    data: {
                        id: $address.val(),
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function(xhr, status, error) {
                        let messageAlert = xhr.responseJSON.message;
                        toastr.error(messageAlert);
                    },
                    complete: function() {
                        hiddenLoader();
                    }
                });
            })
        })
    </script>
@endpush
