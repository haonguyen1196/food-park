@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Delivery Area</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Delivery Area</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.delivery-area.update', $deliveryArea->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Area name</label>
                        <input type="text" class="form-control" name="area_name" value="{{ $deliveryArea->area_name }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Min delevery time</label>
                                <input type="text" class="form-control" name="min_delivery_time"
                                    value="{{ $deliveryArea->min_delivery_time }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Max delevery time</label>
                                <input type="text" class="form-control" name="max_delivery_time"
                                    value="{{ $deliveryArea->max_delivery_time }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Delevery fee</label>
                                <input type="text" class="form-control" name="delivery_fee"
                                    value="{{ $deliveryArea->delivery_fee }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control form-select" name="status">
                                    <option @selected($deliveryArea->status === 1) value="1">Active</option>
                                    <option @selected($deliveryArea->status === 0) value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary">Create</button>
                </form actio>
            </div>
        </div>
    </section>
@endsection
