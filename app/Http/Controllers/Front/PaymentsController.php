<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\App;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payments.create', compact('order'));
    }

    public function createStripePaymentIntent(Order $order)
    {
        $amount = $order->items->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $amount = round($amount);

        $stripe = new StripeClient(config('services.stripe.secret_key'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $amount,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);

        try {
            $payment = new Payment();
            $payment->forceFill([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount,
                'currency' => $paymentIntent->currency,
                'method' => 'stripe',
                'status' => 'pending',
                'transaction_id' => $paymentIntent->id,
                'transaction_data' => json_encode($paymentIntent),
            ])->save();
        } catch (QueryException $e) {
            echo $e->getMessage();
            return;
        }

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function confirm(Request $request, Order $order)
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );


        if ($paymentIntent->status == 'succeeded') {
            try {
                $payment = Payment::where('order_id', $order->id)->first();
                $payment->forceFill([
                    'status' => 'completed',
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();

            } catch (QueryException $e) {
                echo $e->getMessage();
                return;
            }

            event('payment.created', $payment->id);

            return redirect()->route('home', [
                'status' => 'payment-succeeded'
            ]);
        }

        return redirect()->route('orders.payments.create', [
            'order' => $order->id,
            'status' => $paymentIntent->status,
        ]);

    }
}
