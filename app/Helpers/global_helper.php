<?php

/** create unique slug */

use PHPUnit\Framework\MockObject\Stub\ReturnStub;

if(!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($model, $name): string
    {
       $modelClass = "App\\Models\\$model";

       if(!class_exists($modelClass)) {
           throw new \InvalidArgumentException("Model class $modelClass not found");
       }

       $slug = \Str::slug($name);
       $count = 2;

       while ($modelClass::where('slug', $slug)->exists()) {
           $slug = \Str::slug($name) . '-' . $count;
           $count++;
       }

         return $slug;
    }

    /** currency position */
    if(!function_exists('currencyPosition')) {
        function currencyPosition($price): string
        {
           if(config('settings.site_currency_icon_position') == 'left') {
            return config('settings.site_currency_icon') . ($price > 0 ? $price : 0);
           } else {
               return $price . config('settings.site_currency_icon');
           }
        }
    }

    /** cart total */
    if(!function_exists('cartTotal')) {
        function cartTotal()
        {
            $total = 0;

            foreach(Cart::content() as $item) {
                $productPrice = $item->price;
                $productSize = $item->options['product_size']['price'] ?? 0;
                $productOptions = collect($item->options['product_options'])->sum('price');

                $total += ($productPrice + $productSize + $productOptions) * $item->qty;

            }

            return $total;
        }
    }

    /** product total */
    if(!function_exists('productTotal')) {
        function productTotal($rowId)
        {
            $total = 0;

            $product = Cart::get($rowId);

            $productPrice = $product->price;
            $productSize = $product->options['product_size']['price'] ?? 0;
            $productOptions = collect($product->options['product_options'])->sum('price');

            $total += ($productPrice + $productSize + $productOptions) * $product->qty;


            return $total;
        }
    }

    /** grand cart total */
    if(!function_exists('grandCartTotal')) {
        function grandCartTotal($delivery = 0)
        {
        $total = 0;

           $cartTotal = cartTotal();

           if(session()->has('coupon')) {
               $discount = session()->get('coupon')['discount'];

               $total = $cartTotal - $discount > 0 ? ($cartTotal + $delivery) - $discount : 0;

               return $total;

           } else {
               $total = $cartTotal + $delivery;

                return $total;
           }
        }
    }

    /** generate invoice id */
    if(!function_exists('generateInvoiceId')) {
        function generateInvoiceId(): string
        {

            $randomNumber = rand(1, 9999);
            $currentDate = now();

            $invoiceId = $randomNumber.$currentDate->format('Ymd') . $currentDate->format('s');

                return $invoiceId;
        }
    }

    /** product discount in percent */
    if(!function_exists('discountInPercent')) {
        function discountInPercent($originPrice, $discountPrice): string
        {
            $result = ($originPrice - $discountPrice) / $originPrice * 100;

            return round($result, 2);
        }
    }

}