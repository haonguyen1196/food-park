@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Variants ({{ $product->name }})</h1>
        </div>
        <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-2">Go Back</a>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Size</h4>
                        <div class="card-header-action">

                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product-size.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" class="form-control" name="price">
                                    </div>

                                </div>
                            </div>

                            <button class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-body">
                        <table id="product-size-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productSizes as $key => $productSize)
                                    <tr id="{{ $productSize->id }}">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $productSize->name }}
                                        </td>
                                        <td>
                                            {{ currencyPosition($productSize->price) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product-size.destroy', $productSize->id) }}"
                                                class="btn btn-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($productSizes->count() == 0)
                                    <tr>
                                        <td colspan="3" class="text-center">No data found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Option</h4>
                        <div class="card-header-action">

                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product-option.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" class="form-control" name="price">
                                    </div>

                                </div>
                            </div>

                            <button class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-body">
                        <table id="product-optine-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productOptions as $key => $productOption)
                                    <tr id="{{ $productOption->id }}">
                                        <td>
                                            {{ $key + 1 }}
                                        <td>
                                            {{ $productOption->name }}
                                        </td>
                                        <td>
                                            {{ currencyPosition($productOption->price) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product-option.destroy', $productOption->id) }}"
                                                class="btn btn-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($productOptions->count() == 0)
                                    <tr>
                                        <td colspan="3" class="text-center">No data found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>
@endsection
