@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                                                                                                                                                BREADCRUMB START
                                                                                                                                                            ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset('frontend/images/counter_bg.jpg') }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Order</h1>
                    {{-- <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="javascript:;">payment</a></li>
                    </ul> --}}
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
                <div class="col-lg-12">
                    <div class="fp__payment_area">
                        {{-- <h2>Choose your payment gateway</h2> --}}
                        <div class="row">
                            <div class=" text-center">
                                <div>
                                    <i class="fas fa-times"
                                        style="background-color: red;
                                        color: white;
                                        border-radius: 50%;
                                        padding: 29px;
                                        display: inline-block;
                                        font-size: 60px;
                                        width: 120px;
                                        height: 120px;
                                        text-align: center;
                                        line-height: 68px;
                                    ">
                                    </i>
                                </div>
                                <p class="mt-4"
                                    style="font-size: 26px;
                                    font-weight: 500;">
                                    Transaction Faild!
                                </p>
                                <p><b
                                        class="mx-5">{{ session()->has('errors') ? session()->get('errors')->first('error') : '' }}</b>
                                </p>
                                <a class="common_btn mt-4" href="{{ route('dashboard') }}">Go to Payment Page</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
