@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Gallery ({{ $product->name }})</h1>
        </div>
        <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-2">Go Back</a>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Image</h4>
                <div class="card-header-action">

                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product-gallery.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                    </div>
                    <button class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-body">
                <table id="product-gallery-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $image)
                            <tr id="{{ $image->id }}">
                                <td>
                                    <img src="{{ asset($image->image) }}" alt="" style="width: 150px">
                                </td>
                                <td>
                                    <a href="{{ route('admin.product-gallery.destroy', $image->id) }}"
                                        class="btn btn-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        @if ($images->count() == 0)
                            <tr>
                                <td colspan="2" class="text-center">No image found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
