<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\Property;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{

    public function paypal(Request $request)
    {
        $booking = Booking::find($request->id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
        $suggested_price = $booking->suggested_price;
        $provider = new PayPalClient;
        $provider->setApiCredentials(config("paypal"));
        $provider->getAccessToken();
        // dd($suggested_price);
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
                        "value" => $suggested_price,
                    ]
                ]
            ]
        ]);

        // dd($response);
        if (isset($response['id']) && $response['id'] != null) {
            $booking->paypal_order_token = $response['id'];
            $booking->save();
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return response()->json([
                        'success' => true,
                        'approval_url' => $link['href'],
                    ]);
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
            $booking = Booking::where('paypal_order_token', $request->token)->first();
            if (!$booking) {
                return response()->json(['msg' => 'Booking not found'], 404);
            }
            Property::where('id', $booking->property_id)->update(['status' => 'sold']);
            $booking->status = 'confirmed';
            $booking->payment_id = $response['id'];
            $booking->save();

            $payment = new Payment;
            $payment->payment_id = $response['id'];
            $payment->property_id = $booking->property_id;
            $payment->quantity = $booking->suggested_price;
            $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $payment->payer_name = $response['payer']['name']['given_name'];
            $payment->payer_email = $response['payer']['email_address'];
            $payment->payment_status = $response['status'];
            $payment->payment_method = "PayPal";
            $payment->save();

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

