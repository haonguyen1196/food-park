@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Product</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="thumb_image" id="image-upload">
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control form-select select2" name="category_id">
                            <option value=""></option>
                            @foreach ($categories as $category)
                                <option @selected($product->category_id === $category->id) value="{{ $category->id }}">{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" class="form-control" name="price" value="{{ $product->price }}">
                    </div>

                    <div class="form-group">
                        <label>Offer price</label>
                        <input type="text" class="form-control" name="offer_price" value="{{ $product->offer_price }}">
                    </div>

                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" class="form-control" name="quantity" value="{{ $product->quantity }}">
                    </div>

                    <div class="form-group">
                        <label>Short description</label>
                        <textarea type="text" class="form-control" name="short_description">{{ $product->short_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Long description</label>
                        <textarea type="text" class="form-control summernote" name="long_description">{{ $product->long_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Sku</label>
                        <input type="text" class="form-control" name="sku" value="{{ $product->sku }}">
                    </div>

                    <div class="form-group">
                        <label>Seo title</label>
                        <input type="text" class="form-control" name="seo_title" value="{{ $product->seo_title }}">
                    </div>

                    <div class="form-group">
                        <label>Seo description</label>
                        <textarea type="text" class="form-control" name="seo_description">{{ $product->seo_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Show at home</label>
                        <select class="form-control form-select" name="show_at_home">
                            <option @selected($product->show_at_home === 0) value="1">Yes</option>
                            <option @selected($product->show_at_home === 0) value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-select" name="status">
                            <option @selected($product->status === 1) value="1">Active</option>
                            <option @selected($product->status === 0) value="0">Inactive</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Update</button>
                </form actio>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('document').ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset($product->thumb_image) }})',
                'background-size': 'cover',
                'background-position': 'center',
            });
        });
    </script>
@endpush
