<form id="modal_add_to_cart">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fal fa-times"></i></button>
    <div class="fp__cart_popup_img">
        <img src="{{ $product->thumb_image }}" alt="{{ $product->name }}" class="img-fluid w-100">
    </div>
    <div class="fp__cart_popup_text">
        <a href="{{ route('product.show', $product->slug) }}" class="title">{{ $product->name }}</a>
        <p class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
            <span>(201)</span>
        </p>
        @if ($product->offer_price > 0)
            <input type="hidden" value="{{ $product->offer_price }}" name="base_price">
            <h4 class="price">{{ currencyPosition($product->offer_price) }}
                <del>{{ currencyPosition($product->price) }}</del>
            </h4>
        @else
            <input type="hidden" value="{{ $product->price }}" name="base_price">
            <h4 class="price">{{ currencyPosition($product->price) }}</h4>
        @endif

        @if ($product->productSizes->count() > 0)
            <div class="details_size">
                <h5>chọn size</h5>
                @foreach ($product->productSizes as $size)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="{{ $size->id }}"
                            data-price="{{ $size->price }}" name="product_size" id="size-{{ $size->id }}">
                        <label class="form-check-label" for="size-{{ $size->id }}">
                            {{ $size->name }} <span>+ {{ currencyPosition($size->price) }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($product->productOptions->count() > 0)
            <div class="details_extra_item">
                <h5>Tùy chọn <span>(optional)</span></h5>

                @foreach ($product->productOptions as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="product_option[]"
                            value="{{ $option->id }}" data-price="{{ $option->price }}"
                            id="option-{{ $option->id }}">
                        <label class="form-check-label" for="option-{{ $option->id }}">
                            {{ $option->name }} <span>+ {{ currencyPosition($option->price) }}</span>
                        </label>
                    </div>
                @endforeach

            </div>
        @endif



        <div class="details_quentity">
            <h5>chọn số lượng</h5>
            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                <div class="quentity_btn">
                    <button class="btn btn-danger decrement"><i class="fal fa-minus"></i></button>
                    <input id="quantity" name="quantity" type="text" placeholder="1" value="1" readonly>
                    <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
                </div>
                @if ($product->offer_price > 0)
                    <h3 id="total_price">{{ currencyPosition($product->offer_price) }}</h3>
                @else
                    <h3 id="total_price">{{ currencyPosition($product->price) }}</h3>
                @endif
            </div>
        </div>
        <ul class="details_button_area d-flex flex-wrap">
            {{-- <li><a class="common_btn" href="#">add to cart</a></li> --}}
            @if ($product->quantity > 0)
                <button class="common_btn modal_add_to_cart_button" type="submit">Thêm vào giỏ hàng</button>
            @else
                <button class="common_btn" disabled>Hết hàng</button>
            @endif
        </ul>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('input[name="product_size"]').on('change', function() {
            updateTotalPrice();
        })

        $('input[name="product_option[]"]').on('change', function() {
            updateTotalPrice();
        })

        $('.increment').on('click', function(e) {
            e.preventDefault();
            let quantity = $('#quantity');
            let currentQuantity = parseFloat(quantity.val());
            quantity.val(currentQuantity + 1);
            updateTotalPrice();
        })

        $('.decrement').on('click', function(e) {
            e.preventDefault();
            let quantity = $('#quantity');
            let currentQuantity = parseFloat(quantity.val());
            if (currentQuantity > 1) {
                quantity.val(currentQuantity - 1);
            }
            updateTotalPrice();
        })

        function updateTotalPrice() {
            let basePrice = parseFloat($('input[name="base_price"]').val());
            let selectedSizePrice = 0;
            let selectedOptionPrice = 0;
            let quantity = parseFloat($('#quantity').val());

            //caculate selected size price
            let selectedSize = $("input[name='product_size']:checked");

            if (selectedSize.length > 0) {
                selectedSizePrice = parseFloat(selectedSize.data('price'));
            }

            //caculate selected option price
            let selectedOption = $("input[name='product_option[]']:checked");
            selectedOption.each(function(item, element) {
                selectedOptionPrice += parseFloat($(element).data('price'));
            });

            //update total price
            let totalPrice = (basePrice + selectedSizePrice + selectedOptionPrice) * quantity;

            $('#total_price').text("{{ config('settings.site_currency_icon') }}" + totalPrice);
        }

        /** ajax modal add to card */
        $('#modal_add_to_cart').on('submit', function(e) {
            //prevent default form submit
            e.preventDefault();

            //validate select size
            let selectedSize = $("input[name='product_size']");
            if (selectedSize.length > 0) {
                if ($("input[name='product_size']:checked").val() === undefined) {
                    toastr.error('Vui lòng chọn size');
                    return;
                }

            }

            //get form data
            let formData = $(this).serialize();

            //** ajax add to card */
            $.ajax({
                type: 'POST',
                url: "{{ route('add-to-cart') }}",
                data: formData,
                beforeSend: function() {
                    $('.modal_add_to_cart_button').attr('disabled', true);
                    $('.modal_add_to_cart_button').html(
                        `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>
                        Đang tải...`
                    );
                },
                success: function(response) {
                    updateSidebarCart();
                    toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    let errorAlert = xhr.responseJSON.message;
                    toastr.error(errorAlert);
                },
                complete: function() {
                    $('.modal_add_to_cart_button').attr('disabled', false);
                    $('.modal_add_to_cart_button').html('Thêm vào giỏ hàng');
                }
            });
        });
    });
</script>
