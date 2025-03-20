@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Coupon</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $coupon->name }}">
                    </div>

                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control" name="code" value="{{ $coupon->code }}">
                    </div>

                    <div class="form-group">
                        <label>Coupon quantity</label>
                        <input type="text" class="form-control" name="quantity" value="{{ $coupon->quantity }}">
                    </div>

                    <div class="form-group">
                        <label>Min purchase amount</label>
                        <input type="text" class="form-control" name="min_purchase_amount"
                            value="{{ $coupon->min_purchase_amount }}">
                    </div>

                    <div class="form-group">
                        <label>Expire date</label>
                        <input type="date" class="form-control" name="expire_date" value="{{ $coupon->expire_date }}">
                    </div>

                    <div class="form-group">
                        <label>Discount type</label>
                        <select name="discount_type" class="form_select form-control">
                            <option @selected($coupon->discount_type === 'percent') value="percent">Percent</option>
                            <option @selected($coupon->discount_type === 'amount') value="amount">Amount
                                ({{ config('settings.site_currency_icon') }})</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Discount amount</label>
                        <input type="text" class="form-control" name="discount" value="{{ $coupon->discount }}">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-select" name="status">
                            <option @selected($coupon->status === 1) value="1">Active</option>
                            <option @selected($coupon->status === 0) value="0">Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
