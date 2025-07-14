<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Mail\OfferAcceptedMail;
use Illuminate\Support\Facades\Mail;

class OfferController extends Controller
{
    public function accept($id)
    {
        $offer = Offer::with(['user', 'property'])->findOrFail($id);

        if ($offer->status !== 'pending') {
        return response()->json([
        'message' => 'This offer has already been processed.'], 400);
    }
        $offer->status = 'accepted';
        $offer->save();

        Mail::to($offer->user->email)->send(new OfferAcceptedMail($offer));

        return response()->json([
        'message' => 'The offer has been accepted and the email has been sent to the customer.']);
    }
}
