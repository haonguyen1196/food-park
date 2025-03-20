<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlaceNotificationEvent;
use App\Events\RTOrderPlaceNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;


class PaymentController extends Controller
{
    public function index()
    {
        if(!session()->has('address') || !session()->has('delivery_fee')) {
            toastr()->error('Please select an address');
            return redirect()->route('checkout.index');
        }
        $subtotal = cartTotal();
        $deliveryFee = session()->get('delivery_fee');
        $discount = session()->has('coupon') ? session()->get('coupon')['discount'] : 0;
        $grandTotal = grandCartTotal($deliveryFee);

        return view('frontend.pages.payment', compact('subtotal', 'deliveryFee', 'discount', 'grandTotal'));
    }

    public function paymentSuccess()
    {
        return view('frontend.pages.payment-success');
    }

    public function paymentCancel()
    {
        return view('frontend.pages.payment-cancel');
    }

    public function makePayment(Request $request, OrderService $orderService)
    {
        $request->validate([
            'payment_method' => 'required|string|in:paypal,stripe',
        ]);

        if($orderService->createOrder()) {
            switch($request->payment_method) {
                case 'paypal':
                    return response(['redirect_url' => route('paypal.payment')]);
                    break;
                case 'stripe':
                    return response(['redirect_url' => route('stripe.payment')]);
                    break;
                default:
                    break;
            }
        }

    }

    //paypal
    public function setPaypalConfig(): array
    {
        return [
            'mode'    => config('gatewaySettings.paypal_account_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('gatewaySettings.paypal_api_key'),
                'client_secret'     => config('gatewaySettings.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('gatewaySettings.paypal_api_key'),
                'client_secret'     => config('gatewaySettings.paypal_secret_key'),
                'app_id'            => config('gatewaySettings.paypal_app_id'),
            ],

            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('gatewaySettings.paypal_currency'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];
    }

    public function paypalPayment()
    {
        $config = $this->setPaypalConfig();
        $provider =  new PayPalClient($config);
        $provider->getAccessToken();

        /** calculate payable amount */
        $grandTotal = session()->get('grand_total');
        $paymentAmount = round($grandTotal * config('gatewaySettings.paypal_rate'));

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'value' => $paymentAmount,
                        'currency_code' => config('gatewaySettings.paypal_currency'),
                    ]
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id'] != null) {
            foreach($response['links'] as $link) {
                if($link['rel'] == 'approve') {
                    return redirect($link['href']);
                }
            }
        }
    }

    public function paypalSuccess(Request $request, OrderService $orderService)
    {
        $config = $this->setPaypalConfig();
        $provider =  new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            $orderId = session()->get('order_id');
            $captures = $response['purchase_units'][0]['payments']['captures'][0];
            $paymentInfo = [
                'transaction_id' => $captures['id'],
                'currency' => $captures['amount']['currency_code'],
                'status' => 'completed',
            ];

            //update order payment status
            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'PayPal');

            //send mail
            OrderPlaceNotificationEvent::dispatch($orderId);

            //real time notification
            RTOrderPlaceNotificationEvent::dispatch(Order::find($orderId));

            //clear session
            $orderService->clearSession();

            return redirect()->route('payment.success');
        } else {
            $this->transactionFailUpdateStatus('PayPal');
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }

    public function paypalCancel()
    {
        $this->transactionFailUpdateStatus('PayPal');
        return redirect()->route('payment.cancel');
    }

    //stripe
    public function stripePayment()
    {
        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));

        /** calculate payable amount */
        $grandTotal = session()->get('grand_total');
        $paymentAmount = round($grandTotal * config('gatewaySettings.paypal_rate')) * 100;

        $response = StripeSession::create([
            'line_items' => [
               [
                'price_data' => [
                    'currency' => config('gatewaySettings.stripe_currency'),
                    'product_data' => [
                        'name' => 'Order Payment',
                    ],
                    'unit_amount' => $paymentAmount,
                ],
                'quantity' => 1,
               ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($response->url);
    }

    public function stripeSuccess(Request $request, OrderService $orderService)
    {
        $sessionId = $request->session_id;
        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));

        $response = StripeSession::retrieve($sessionId);

        if($response->payment_status === 'paid') {
            $orderId = session()->get('order_id');

            $paymentInfo = [
                'transaction_id' => $response->payment_intent,
                'currency' => $response->currency,
                'status' => 'completed',
            ];

            //update order payment status
            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');

            //send mail
            OrderPlaceNotificationEvent::dispatch($orderId);

            //real time notification
            RTOrderPlaceNotificationEvent::dispatch(Order::find($orderId));

            //clear session
            $orderService->clearSession();

            return redirect()->route('payment.success');
        } else {
            $this->transactionFailUpdateStatus('Stripe');
            return redirect()->route('payment.cancel');
        }

        return redirect()->route('payment.success');
    }

    public function stripeCancel()
    {
        $this->transactionFailUpdateStatus('Stripe');
        return redirect()->route('payment.cancel');
    }

    public function transactionFailUpdateStatus($gateway)
    {
        $orderId = session()->get('order_id');

        $paymentInfo = [
            'transaction_id' => '',
            'currency' => '',
            'status' => 'failed',
        ];

        //update order payment status
        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gateway);
    }
}