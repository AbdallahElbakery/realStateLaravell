<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Resources\BookingResource;

class BookingAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::all();
        $allBookings = BookingResource::collection($bookings);
        return response()->json(["message" => "returened successflly", "allBookings" => $allBookings]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(["message" => "this booking is not find"], 404);
        }
        $bookingDetails = new BookingResource($booking);
        return response()->json(["message" => "returned sucessfully", "booking" => $bookingDetails]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::find($id);
        $booking->update([
            "status" => $request->status,
        ]);
        return response()->json(["message" => "updated", "newBooking" => $booking]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(["message" => "this booking is not find"], 404);
        }
        $booking->delete();
        return response()->json(["message" => "delted successfully"]);
    }
}
