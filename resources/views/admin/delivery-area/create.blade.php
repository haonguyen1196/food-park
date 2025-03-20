@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Delivery Area</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Delivery Area</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.delivery-area.store') }}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label>Area name</label>
                        <input type="text" class="form-control" name="area_name" value="{{ old('area_name') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Min delevery time</label>
                                <input type="text" class="form-control" name="min_delivery_time"
                                    value="{{ old('min_delivery_time') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Max delevery time</label>
                                <input type="text" class="form-control" name="max_delivery_time"
                                    value="{{ old('max_delivery_time') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Delevery fee</label>
                                <input type="text" class="form-control" name="delivery_fee"
                                    value="{{ old('delivery_fee') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control form-select" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
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
