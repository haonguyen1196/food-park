<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class OrderService
{
    public function createOrder()
    {
        try {
            $order = Order::create([
                'invoice_id' => generateInvoiceId(),
                'user_id' => auth()->id(),
                'address' => session('address'),
                'address_id' => session('address_id'),
                'discount' => session('coupon')['discount'] ?? 0,
                'delivery_charge' => session('delivery_fee'),
                'subtotal' => cartTotal(),
                'grand_total' => grandCartTotal(session('delivery_fee')),
                'product_qty' => \Cart::content()->count(),
                'payment_method' => NUll,
                'payment_status' => 'pending',
                'payment_approve_date' => NULL,
                'transaction_id' => NULL,
                'coupon_info' => json_encode(session('coupon')),
                'currency_name' => Null,
                'order_status' => 'pending',
            ]);

            foreach(\Cart::content() as $item) {
               OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item->name,
                'product_id' => $item->id,
                'unit_price' => $item->price,
                'qty' => $item->qty,
                'product_size' => json_encode($item->options['product_size']),
                'product_option' => json_encode($item->options['product_options'])
               ]);
            }
            session()->put('order_id', $order->id);
            session()->put('grand_total', $order->grand_total);

            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    public function clearSession()
    {
        \Cart::destroy();
        session()->forget('coupon');
        session()->forget('address');
        session()->forget('address_id');
        session()->forget('delivery_fee');
        session()->forget('order_id');
        session()->forget('grand_total');
    }
}