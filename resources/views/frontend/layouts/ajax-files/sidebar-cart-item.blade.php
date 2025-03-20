<input type="hidden" value="{{ cartTotal() }}" id="cart_total">
<input type="hidden" value="{{ count(Cart::content()) }}" id="cart_product_count">
@foreach (Cart::content() as $cartItem)
    <li>
        <div class="menu_cart_img">
            <img src="{{ asset($cartItem->options['product_info']['image']) }}" alt="menu" class="img-fluid w-100">
        </div>
        <div class="menu_cart_text">
            <a class="title" href="#">{{ $cartItem->name }}</a>
            <p class="size">Qty: {{ $cartItem->qty }}</p>
            @if (@$cartItem->options['product_size']['price'] > 0)
                <p class="size">{{ @$cartItem->options['product_size']['name'] }}
                    ({{ currencyPosition(@$cartItem->options['product_size']['price']) }})</p>
            @endif

            @foreach ($cartItem->options['product_options'] as $optionItem)
                <span class="extra">{{ $optionItem['name'] }} {{ currencyPosition($optionItem['price']) }}</span>
            @endforeach
            <p class="price">{{ currencyPosition($cartItem->price) }}</p>
        </div>
        <span class="del_icon" onclick="removeProductFromSidebar('{{ $cartItem->rowId }}')">
            <i class="fal fa-times"></i>
        </span>
    </li>
@endforeach
