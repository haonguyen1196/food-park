@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Coupon</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupon.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                    </div>

                    <div class="form-group">
                        <label>Coupon quantity</label>
                        <input type="text" class="form-control" name="quantity" value="{{ old('quantity') }}">
                    </div>

                    <div class="form-group">
                        <label>Min purchase amount</label>
                        <input type="text" class="form-control" name="min_purchase_amount"
                            value="{{ old('min_purchase_amount') }}">
                    </div>

                    <div class="form-group">
                        <label>Expire date</label>
                        <input type="date" class="form-control" name="expire_date" value="{{ old('expire_date') }}">
                    </div>

                    <div class="form-group">
                        <label>Discount type</label>
                        <select name="discount_type" class="form_select form-control">
                            <option value="percent">Percent</option>
                            <option value="amount">Amount ({{ config('settings.site_currency_icon') }})</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Discount amount</label>
                        <input type="text" class="form-control" name="discount" value="{{ old('discount') }}">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection
