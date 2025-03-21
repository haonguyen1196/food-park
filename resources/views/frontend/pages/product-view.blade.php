@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                                                                                                                                                                                                                                                                                                    BREADCRUMB START
                                                                                                                                                                                                                                                                                                                ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Chi tiết sản phẩm</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">trang chủ</a></li>
                        <li><a href="javascrip:;">chi tiết sản phẩm</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                                                                                                                                                                                                                                                                                                    BREADCRUMB END
                                                                                                                                                                                                                                                                                                                ==============================-->


    <!--=============================
                                                                                                                                                                                                                                                                                                                    MENU DETAILS START
                                                                                                                                                                                                                                                                                                                ==============================-->
    <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box fp__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                <li><img class="zoom ing-fluid w-100" src="{{ $product->thumb_image }}" alt="product"></li>
                                @foreach ($product->productImages as $image)
                                    <li><img class="zoom ing-fluid w-100" src="{{ $image->image }}" alt="product"></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_details_text">
                        <h2>{{ $product->name }}</h2>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(201)</span>
                        </p>
                        <form id="v_add_to_cart_form">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @if ($product->offer_price > 0)
                                <input type="hidden" value="{{ $product->offer_price }}" name="base_price"
                                    class="V_base_price">
                                <h3 class="price">{{ currencyPosition($product->offer_price) }}
                                    <del>{{ currencyPosition($product->price) }}</del>
                                </h3>
                            @else
                                <input type="hidden" value="{{ $product->price }}" name="base_price" class="V_base_price">
                                <h3 class="price">{{ currencyPosition($product->price) }}</h3>
                            @endif
                            <p class="short_description">{!! $product->short_description !!}</p>

                            @if ($product->productSizes->count() > 0)
                                <div class="details_size">
                                    <h5>chọn size</h5>
                                    @foreach ($product->productSizes as $size)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_size" type="radio"
                                                name="product_size" value="{{ $size->id }}"
                                                id="size-{{ $size->name }}" data-price="{{ $size->price }}">
                                            <label class="form-check-label" for="size-{{ $size->name }}">
                                                {{ $size->name }} <span>+ {{ currencyPosition($size->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($product->productOptions->count() > 0)
                                <div class="details_extra_item">
                                    <h5>tùy chọn <span>(optional)</span></h5>
                                    @foreach ($product->productOptions as $option)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_option" type="checkbox"
                                                name="product_option[]" value="{{ $option->id }}"
                                                id="option-{{ $option->name }}" data-price="{{ $option->price }}">
                                            <label class="form-check-label" for="option-{{ $option->name }}">
                                                {{ $option->name }} <span>+ {{ currencyPosition($option->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="details_quentity">
                                <h5>chọn số lượng</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger v_decrement"><i class="fal fa-minus"></i></button>
                                        <input type="text" name="quantity" placeholder="1" id="v_quantity" readonly
                                            value="1">
                                        <button class="btn btn-success v_increment"><i class="fal fa-plus"></i></button>
                                    </div>
                                    <h3 id="v_total_price">
                                        {{ currencyPosition($product->offer_price > 0 ? $product->offer_price : $product->price) }}
                                    </h3>
                                </div>
                            </div>
                        </form>
                        <ul class="details_button_area d-flex flex-wrap">
                            @if ($product->stock > 0)
                                <li><a class="common_btn v_cart_button" href="#">thêm vào giỏ hàng</a></li>
                            @else
                                <li><a class="common_btn" href="javascript:;" disabled>hết hàng</a></li>
                            @endif
                            <li><a class="wishlist" href="#"><i class="far fa-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_description_area mt_100 xs_mt_70">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">mô tả</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">đánh giá</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">
                                    {!! $product->long_description !!}
                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="fp__review_area">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4>04 đánh giá</h4>
                                            <div class="fp__comment pt-0 mt_20">
                                                <div class="fp__single_comment m-0 border-0">
                                                    <img src="images/comment_img_1.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>Michel Holder <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/chef_1.jpg" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>salina khan <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/comment_img_2.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>Mouna Sthesia <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/chef_3.jpg" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3>marjan janifar <span>29 oct 2022 </span></h3>
                                                        <span class="rating">
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fas fa-star"></i>
                                                            <i class="fad fa-star-half-alt"></i>
                                                            <i class="fal fa-star"></i>
                                                            <b>(120)</b>
                                                        </span>
                                                        <p>Sure there isn't anything embarrassing hiidden in the
                                                            middles of text. All erators on the Internet
                                                            tend to repeat predefined chunks</p>
                                                    </div>
                                                </div>
                                                <a href="#" class="load_more">load More</a>
                                            </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="fp__post_review">
                                                <h4>write a Review</h4>
                                                <form>
                                                    <p class="rating">
                                                        <span>select your rating : </span>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <input type="text" placeholder="Name">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <input type="email" placeholder="Email">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <textarea rows="3" placeholder="Write your review"></textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <button class="common_btn" type="submit">submit
                                                                review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            @if (count($relatedProducts) > 0)
                <div class="fp__related_menu mt_90 xs_mt_60">
                    <h2>sản phẩm liên quan</h2>
                    <div class="row related_product_slider">

                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                                <div class="fp__menu_item">
                                    <div class="fp__menu_item_img">
                                        <img src="{{ asset($relatedProduct->thumb_image) }}"
                                            alt="{{ $relatedProduct->name }}" class="img-fluid w-100">
                                        <a class="category" href="#">{{ $relatedProduct->categories->name }}</a>
                                    </div>
                                    <div class="fp__menu_item_text">
                                        <p class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                            <span>74</span>
                                        </p>
                                        <a class="title"
                                            href="{{ route('product.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
                                        @if ($relatedProduct->offer_price > 0)
                                            <h5 class="price">{{ currencyPosition($relatedProduct->offer_price) }}
                                                <del>{{ currencyPosition($relatedProduct->price) }}</del>
                                            </h5>
                                        @else
                                            <h5 class="price">{{ currencyPosition($relatedProduct->price) }}</h5>
                                        @endif
                                        <ul class="d-flex flex-wrap justify-content-center">
                                            <li><a href="#" onclick="loadProductModal({{ $relatedProduct->id }})"
                                                    data-bs-toggle="modal" data-bs-target="#cartModal"><i
                                                        class="fas fa-shopping-basket"></i></a></li>
                                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                            <li><a href="#"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.v_product_size').on('change', function() {
                updateTotalPrice();
            })

            $('.v_product_option').on('change', function() {
                updateTotalPrice();
            })

            $('.v_increment').on('click', function(e) {
                e.preventDefault();
                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                quantity.val(currentQuantity + 1);
                updateTotalPrice();
            })

            $('.v_decrement').on('click', function(e) {
                e.preventDefault();
                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                if (currentQuantity > 1) {
                    quantity.val(currentQuantity - 1);
                }
                updateTotalPrice();
            })

            function updateTotalPrice() {
                let basePrice = parseFloat($('.V_base_price').val());
                let selectedSizePrice = 0;
                let selectedOptionPrice = 0;
                let quantity = parseFloat($('#v_quantity').val());

                //caculate selected size price
                let selectedSize = $(".v_product_size:checked");

                if (selectedSize.length > 0) {
                    selectedSizePrice = parseFloat(selectedSize.data('price'));
                }

                //caculate selected option price
                let selectedOption = $(".v_product_option:checked");
                selectedOption.each(function(item, element) {
                    selectedOptionPrice += parseFloat($(element).data('price'));
                });


                //update total price
                let totalPrice = (basePrice + selectedSizePrice + selectedOptionPrice) * quantity;

                $('#v_total_price').text("{{ currencyPosition(':totalPrice') }}".replace(':totalPrice',
                    totalPrice));
            }

            //handle add to cart
            $('.v_cart_button').on('click', function(e) {
                e.preventDefault();
                $('#v_add_to_cart_form').submit();
            })

            $('#v_add_to_cart_form').on('submit', function(e) {
                //prevent default form submit
                e.preventDefault();

                //validate select size
                let selectedSize = $(".v_product_size");
                if (selectedSize.length > 0) {
                    if ($(".v_product_size:checked").val() === undefined) {
                        toastr.error('Please select a size');
                        return;
                    }

                }

                //get form data
                let formData = $(this).serialize();

                //** ajax add to card */
                $.ajax({
                    type: 'POST',
                    url: "{{ route('add-to-cart') }}",
                    data: formData,
                    beforeSend: function() {
                        $('.v_cart_button').attr('disabled', true);
                        $('.v_cart_button').html(
                            `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>
                            Loading...`
                        );
                    },
                    success: function(response) {
                        updateSidebarCart();
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errorAlert = xhr.responseJSON.message;
                        toastr.error(errorAlert);
                    },
                    complete: function() {
                        $('.v_cart_button').attr('disabled', false);
                        $('.v_cart_button').html('add to cart');
                    }
                });
            })
        });
    </script>
@endpush
