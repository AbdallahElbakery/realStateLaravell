<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class SellerBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $sellerId = auth()->id();

            if (!$sellerId) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $propertyIds = Property::where('seller_id', $sellerId)->pluck('id');

            if ($propertyIds->isEmpty()) {
                return response()->json([
                    'message' => 'No properties found for this seller.'
                ], 404);
            }

            $bookings = Booking::with(['user', 'property'])
                ->whereIn('property_id', $propertyIds)
                ->latest()
                ->get();

            return response()->json([
                'message' => 'Bookings retrieved successfully',
                'data' => $bookings
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching seller bookings: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while fetching bookings. Please try again later.'
            ], 500);
        }
    }

    public function confirm($id)
    {
        $booking = Booking::with('property')->findOrFail($id);

        if (!$booking->property || $booking->property->seller_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking->status = 'confirmed';
        $booking->save();

        $property = $booking->property;
        $property->status = 'sold';
        $property->save();

        return response()->json(['message' => 'Booking confirmed and property marked as sold']);
    }

    public function cancel($id)
    {
        try {
            $booking = Booking::with('property')->findOrFail($id);

            if (!$booking->property || $booking->property->seller_id !== auth()->id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $booking->status = 'cancelled';
            $booking->save();

            return response()->json([
                'message' => 'Booking cancelled successfully',
                'data' => [
                    'booking_id' => $booking->id,
                    'status' => $booking->status
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error("Error cancelling booking: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }

}
