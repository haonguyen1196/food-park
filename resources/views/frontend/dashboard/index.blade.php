@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                                                                                                                                                                                                                                                                                        BREADCRUMB START
                                                                                                                                                                                                                                                                                                    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>bảng điều khiển</h1>
                    <ul>
                        <li><a href="index.html">trang chủ</a></li>
                        <li><a href="#">bảng điều khiển</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                                                                                                                                                                                                                                                                                        BREADCRUMB END
                                                                                                                                                                                                                                                                                                    ==============================-->


    <!--=========================
                                                                                                                                                                                                                                                                                                        DASHBOARD START
                                                                                                                                                                                                                                                                                                    ==========================-->
    <section class="fp__dashboard mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="fp__dashboard_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__dashboard_menu">
                            <div class="dasboard_header">
                                <div class="dasboard_header_img">
                                    <img src="{{ auth()->user()->avatar }}" alt="user" class="img-fluid w-100">
                                    <label for="upload"><i class="far fa-camera"></i></label>
                                    <form id="avatar_form">
                                        <input type="file" id="upload" hidden name="avatar">
                                    </form>
                                </div>
                                <h2>{{ auth()->user()->name }}</h2>
                            </div>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true"><span><i
                                            class="fas fa-user"></i></span> Thông tin cá nhân</button>

                                <button class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-address" type="button" role="tab"
                                    aria-controls="v-pills-address" aria-selected="true"><span><i
                                            class="fas fa-user"></i></span>địa chỉ</button>

                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false"><span><i
                                            class="fas fa-bags-shopping"></i></span> Đơn hàng</button>

                                <button class="nav-link" id="v-pills-wishlist-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-wishlist" type="button" role="tab"
                                    aria-controls="v-pills-wishlist" aria-selected="false"><span><i
                                            class="far fa-heart"></i></span> danh sách yêu thích</button>

                                {{-- <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-messages" type="button" role="tab"
                                    aria-controls="v-pills-messages" aria-selected="false"><span><i
                                            class="fas fa-star"></i></span> Reviews</button> --}}
                                @php
                                    $unseenMessage = \App\Models\Chat::where('receiver_id', auth()->id())
                                        ->where('seen', 0)
                                        ->count();
                                @endphp
                                <button class="nav-link fp_chat_message" id="v-pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-settings" type="button" role="tab"
                                    aria-controls="v-pills-settings" aria-selected="false"><span><i
                                            class="far fa-comment-dots"></i></span> Tin nhắn
                                    <b class="unseen-message" style="display: {{ $unseenMessage > 0 ? 'block' : 'none' }}">
                                        {{ $unseenMessage > 0 ? $unseenMessage : 0 }}
                                    </b>

                                </button>

                                <button class="nav-link" id="v-pills-change-password-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-change-password" type="button" role="tab"
                                    aria-controls="v-pills-change-password" aria-selected="false"><span><i
                                            class="fas fa-user-lock"></i></span> Thay đổi mật khẩu </button>


                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        onclick="event.preventDefault();
                                                            this.closest('form').submit();"
                                        class="nav-link  w-100" type="button"><span> <i class="fas fa-sign-out-alt"></i>
                                        </span> đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__dashboard_content">
                            <div class="tab-content" id="v-pills-tabContent">

                                @include('frontend.dashboard.section.parsonal-info-section')

                                @include('frontend.dashboard.section.address-section')

                                @include('frontend.dashboard.section.message-section')

                                @include('frontend.dashboard.section.order-section')

                                @include('frontend.dashboard.section.wishlist-section')


                                <div class="tab-pane fade " id="v-pills-messages2" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab2">
                                    <div class="fp_dashboard_body">
                                        <h3>danh sách yêu thích</h3>
                                        <div class="fp__dashoard_wishlist">

                                            <div class="row">
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_1.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">Biryani</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>10</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">Hyderabadi
                                                                biryani</a>
                                                            <h5 class="price">$70.00</h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a>
                                                                </li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_2.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">chicken</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>145</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">chicken Masala</a>
                                                            <h5 class="price">$80.00 <del>90.00</del></h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a>
                                                                </li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_3.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">grill</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>54</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">daria
                                                                shevtsova</a>
                                                            <h5 class="price">$99.00</h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a>
                                                                </li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_4.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">chicken</a>
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
                                                            <a class="title" href="menu_details.html">chicken Masala</a>
                                                            <h5 class="price">$80.00 <del>90.00</del></h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a>
                                                                </li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_5.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">chicken</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>120</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">chicken Masala</a>
                                                            <h5 class="price">$80.00 <del>90.00</del></h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a>
                                                                </li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-sm-6 col-lg-6">
                                                    <div class="fp__menu_item">
                                                        <div class="fp__menu_item_img">
                                                            <img src="images/menu2_img_6.jpg" alt="menu"
                                                                class="img-fluid w-100">
                                                            <a class="category" href="#">Biryani</a>
                                                        </div>
                                                        <div class="fp__menu_item_text">
                                                            <p class="rating">
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                                <i class="far fa-star"></i>
                                                                <span>514</span>
                                                            </p>
                                                            <a class="title" href="menu_details.html">Hyderabadi
                                                                biryani</a>
                                                            <h5 class="price">$70.00</h5>
                                                            <ul class="d-flex flex-wrap justify-content-center">
                                                                <li><a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#cartModal"><i
                                                                            class="fas fa-shopping-basket"></i></a></li>
                                                                <li><a href="#"><i class="fal fa-heart"></i></a>
                                                                </li>
                                                                <li><a href="#"><i class="far fa-eye"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="fp__pagination mt_35">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <nav aria-label="...">
                                                            <ul class="pagination justify-content-start">
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#"><i
                                                                            class="fas fa-long-arrow-alt-left"></i></a>
                                                                </li>
                                                                <li class="page-item"><a class="page-link"
                                                                        href="#">1</a></li>
                                                                <li class="page-item active"><a class="page-link"
                                                                        href="#">2</a></li>
                                                                <li class="page-item"><a class="page-link"
                                                                        href="#">3</a></li>
                                                                <li class="page-item">
                                                                    <a class="page-link" href="#"><i
                                                                            class="fas fa-long-arrow-alt-right"></i></a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                    aria-labelledby="v-pills-messages-tab">
                                    <div class="fp_dashboard_body dashboard_review">
                                        <h3>review</h3>
                                        <div class="fp__review_area">
                                            <div class="fp__comment pt-0 mt_20">
                                                <div class="fp__single_comment m-0 border-0">
                                                    <img src="images/menu1.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">mamun ahmed shuvo</a> <span>29 oct 2022
                                                            </span>
                                                        </h3>
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
                                                        <span class="status active">active</span>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/menu2.png" alt=" review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">asaduzzaman khan</a> <span>29 oct 2022
                                                            </span>
                                                        </h3>
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
                                                        <span class="status inactive">inactive</span>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/menu3.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">ariful islam rupom</a> <span>29 oct 2022
                                                            </span>
                                                        </h3>
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
                                                        <span class="status active">active</span>
                                                    </div>
                                                </div>
                                                <div class="fp__single_comment">
                                                    <img src="images/menu4.png" alt="review" class="img-fluid">
                                                    <div class="fp__single_comm_text">
                                                        <h3><a href="#">ali ahmed jakir</a> <span>29 oct 2022 </span>
                                                        </h3>
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
                                                        <span class="status inactive">inactive</span>
                                                    </div>
                                                </div>
                                                <a href="#" class="load_more">load More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('frontend.dashboard.section.change-password')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#upload').on('change', function() {
                let form = $('#avatar_form')[0];
                let data = new FormData(form);

                $.ajax({
                    url: "{{ route('profile.avatar.update') }}",
                    method: 'POST',
                    data: data,
                    //send image
                    contentType: false,
                    //send image
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            //reload page
                            location.reload();
                        } else {
                            toastr.error(response.message['avatar'][0]);
                        }
                    }
                });
            })

            //open chat box
            @if ($open === 'message')
                $('#v-pills-settings-tab').click();
            @endif
        });
    </script>
@endpush
