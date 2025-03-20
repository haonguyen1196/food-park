@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Daily Ofer</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Daily Ofer</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.daily-offer.store') }}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="form-group">
                        <label>Product</label>
                        <select name="product_id" id="product_search">
                            <option value="">Select Product</option>
                        </select>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#product_search').select2({
                ajax: {
                    url: '{{ route('admin.daily-offer.search-product') }}',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data) { //hàm xử lý kết quả tìm kiếm
                        return {
                            results: $.map(data, function(product) {
                                return {
                                    text: product.name,
                                    id: product.id,
                                    image_url: product.thumb_image
                                }
                            })
                        };
                    }
                },
                minimumInputLength: 3, //ghi chú: số ký tự tối thiểu để tìm kiếm
                templateResult: formatProduct, //hàm xử lý hiển thị kết quả tìm kiếm
                escapeMarkup: function(m) {
                    return m; //hàm xử lý ký tự đặc biệt
                }
            });

            //hàm xử lý định dạng hiển thị của select2
            function formatProduct(product) {

                var $product = $(
                    '<span><img src="' + product.image_url +
                    '" class="img-thumbnail" style="width: 50px; height: 50px;"> ' + product.text + '</span>'
                );

                return $product;
            }
        });
    </script>
@endpush
