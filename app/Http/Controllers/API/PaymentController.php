<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{

    public function paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config("paypal"));
        $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->suggested_price
                    ]
                ]
            ]
        ]);

        // dd($response);
        if (isset($response['id']) && $response['id'] != null) {

            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    session()->put('property_name', $request->property_name);
                    session()->put('quantity', $request->quantity);
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $booking=Booking::where('paypal_order_token',$request->token)->first();
            if($booking){
                $booking->status = 'paid';
                $booking->payment_id = $response['id'];
                $booking->save();
            }
            $payment = new Payment;
            $payment->payment_id = $response['id'];
            $payment->property_name = session()->get('property_name');
            $payment->quantity = session()->get('quantity');
            $payment->amount = $response['purchase_units'][0]['payments']['capture']['value'];
            $payment->currency = $response['purchase_units'][0]['payments']['capture']['currency_code'];
            $payment->payer_name = $response['payer']['name']['given_name'];
            $payment->payer_email = $response['payer']['email_address'];
            $payment->payment_status = $response['status'];
            $payment->payment_method = "PayPal";
            $payment->save();

            session()->forget("property_name");
            session()->forget("quantity");
            return "Payment is successful";
        } else {
            return redirect()->route('cancel');
        }

    }


    public function cancel()
    {
        return "payment is canceled";
    }
}

