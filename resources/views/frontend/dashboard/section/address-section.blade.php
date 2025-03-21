<div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab">
    <div class="fp_dashboard_body address_body">
        <h3>địa chỉ <a class="dash_add_new_address"><i class="far fa-plus"></i> thêm mới
            </a>
        </h3>
        <div class="fp_dashboard_address">
            <div class="fp_dashboard_existing_address">
                <div class="row">
                    @foreach ($userAddress as $address)
                        <div class="col-md-6 address-item">
                            <div class="fp__checkout_single_address">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <span class="icon">
                                            @if ($address->type == 'office')
                                                <i class="fas fa-home"></i>
                                            @else
                                                <i class="far fa-car-building"></i>
                                            @endif
                                            {{ $address->type }}
                                        </span>
                                        <span class="address">{{ $address->address }},
                                            {{ $address->deliveryArea->area_name }}
                                        </span>
                                    </label>
                                </div>
                                <ul>
                                    <li><a class="dash_edit_btn show_edit_setion"
                                            data-class="edit_section_{{ $address->id }}"><i
                                                class="far fa-edit"></i></a></li>
                                    <li><a href="{{ route('address.destroy', $address->id) }}"
                                            class="dash_del_icon delete-item"><i class="fas fa-trash-alt"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
            <div class="fp_dashboard_new_address ">
                <form method="POST" action="{{ route('address.store') }}">
                    <div class="row">
                        @csrf
                        <div class="col-12">
                            <h4>thêm địa chỉ mới</h4>
                        </div>

                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="fp__check_single_form">
                                <select id="select_js3" name="delivery_area_id">
                                    <option value="">chọn khu vực giao hàng</option>
                                    @foreach ($deliveryAreas as $deliveryArea)
                                        <option value="{{ $deliveryArea->id }}">{{ $deliveryArea->area_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="fp__check_single_form">
                                <input type="text" placeholder="Họ" name="first_name">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="fp__check_single_form">
                                <input type="text" placeholder="Tên" name="last_name">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="fp__check_single_form">
                                <input type="text" placeholder="Số điện thoại *" name="phone">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 col-xl-6">
                            <div class="fp__check_single_form">
                                <input type="email" placeholder="Email *" name="email">
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
                                    <input class="form-check-input" type="radio" name="type" id="flexRadioDefault1"
                                        value="home">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Nhà
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2"
                                        value="office">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Văn phòng
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="common_btn cancel_new_address">hủy</button>
                            <button type="submit" class="common_btn">lưu địa chỉ</button>
                        </div>
                    </div>
                </form>
            </div>

            @foreach ($userAddress as $address)
                <div class="fp_dashboard_edit_address edit_section_{{ $address->id }}">
                    <form method="POST" action="{{ route('address.update', $address->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <h4>chỉnh sửa địa chỉ </h4>
                            </div>

                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="fp__check_single_form">
                                    <select class="nice-select" name="delivery_area_id">
                                        <option value="">chọn địa chỉ giao hàng</option>
                                        @foreach ($deliveryAreas as $deliveryArea)
                                            <option @selected($address->delivery_area_id === $deliveryArea->id) value="{{ $deliveryArea->id }}">
                                                {{ $deliveryArea->area_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="text" placeholder="Họ" name="first_name"
                                        value="{{ $address->first_name }}">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="text" placeholder="Tên" name="last_name"
                                        value="{{ $address->last_name }}">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="text" placeholder="Email" name="email"
                                        value="{{ $address->email }}">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-12 col-xl-6">
                                <div class="fp__check_single_form">
                                    <input type="text" placeholder="Số điện thoại" name="phone"
                                        value="{{ $address->phone }}">
                                </div>
                            </div>


                            <div class="col-md-12 col-lg-12 col-xl-12">
                                <div class="fp__check_single_form">
                                    <textarea cols="3" rows="4" placeholder="Địa chỉ" name="address">{{ $address->address }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="fp__check_single_form check_area">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type"
                                            id="flexRadioDefault12" {{ $address->type == 'home' ? 'checked' : '' }}
                                            value="home">
                                        <label class="form-check-label" for="flexRadioDefault12">
                                            Nhà
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type"
                                            id="flexRadioDefault22" {{ $address->type == 'office' ? 'checked' : '' }}
                                            value="office">
                                        <label class="form-check-label" for="flexRadioDefault22">
                                            Văn phòng
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="common_btn cancel_edit_address">cancel</button>

                                <button type="submit" class="common_btn">cập nhật địa chỉ</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach

        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            //show form eidt
            $('.show_edit_setion').on('click', function() {
                var class_name = $(this).data('class');
                $('.fp_dashboard_edit_address').hide();
                $('.fp_dashboard_existing_address').hide();
                $('.' + class_name).show();
            })

            //cancel form edti
            $('.cancel_edit_address').on('click', function() {
                $('.fp_dashboard_edit_address').hide();
                $('.fp_dashboard_existing_address').show();
            })
        });
    </script>
@endpush
