<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Resources\PaymentResource;
class PaymentAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::all();
        $allPayments = PaymentResource::collection($payments);
        return response()->json(["message" => "returned all payments", "payments" => $allPayments]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::find($id);
        return response()->json(["message" => "returned this payment", "payment" => $payment]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(["message" => "this payment is not found"], 404);
        }
        $payment->delete();
    }
}
