<script>
    $(document).ready(function() {
        $('body').on('click', '.delete-item', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let $this = $(this);

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                toastr.success(response.message);
                                // find class address-item is parent and remove it
                                $this.closest('.address-item').remove();

                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(err) {
                            toastr.error('Something went wrong!');
                        }
                    });
                }
            });
        })
    });

    function loadProductModal($productId) {
        $.ajax({
            url: '{{ route('load.product.modal', ':productId') }}'.replace(':productId', $productId),
            type: 'GET',
            beforeSend: function() {
                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
            },
            success: function(response) {
                $('.load_product_modal_body').html(response);
                $('#cartModal').modal('show');
            },
            error: function(error) {
                console.log(error);
            },
            complete: function() {
                $('.overlay-container').addClass('d-none');
                $('.overlay').removeClass('active');
            }
        });
    }

    //add product to wishlist
    function addToWishlist($productId) {
        $.ajax({
            url: '{{ route('wishlist.store', ':productId') }}'.replace(':productId', $productId),
            type: 'GET',
            beforeSend: function() {
                showLoader();
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                }
            },
            error: function(xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value);
                });
            },
            complete: function() {
                hiddenLoader();
            }
        });
    }

    function updateSidebarCart(callback = null) {
        $.ajax({
            url: '{{ route('get-cart-products') }}',
            type: 'GET',
            success: function(response) {
                $('.cart-content').html(response);
                let cartTotal = $('#cart_total').val();
                let cartCount = $('#cart_product_count').val();
                $('#cart_subtotal').text("{{ currencyPosition(':cartTotal') }}".replace(':cartTotal',
                    cartTotal));
                $('.cart_count').text(cartCount);

                if (callback && typeof callback === 'function') {
                    callback();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function removeProductFromSidebar(rowId) {
        $.ajax({
            url: '{{ route('remove-cart-product', ':rowId') }}'.replace(':rowId', rowId),
            type: 'POST',
            beforeSend: function() {
                $('.overlay-container').removeClass('d-none');
                $('.overlay').addClass('active');
            },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    updateSidebarCart(function() {
                        $('.overlay-container').addClass('d-none');
                        $('.overlay').removeClass('active');
                    });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = xhr.responseJSON.message;
                toastr.error(errorMessage);
            }
        });

    }

    /** show loader  */
    function showLoader() {
        $('.overlay-container').removeClass('d-none');
        $('.overlay').addClass('active');
    }

    /** hide loader */
    function hiddenLoader() {
        $('.overlay-container').addClass('d-none');
        $('.overlay').removeClass('active');
    }
</script>
