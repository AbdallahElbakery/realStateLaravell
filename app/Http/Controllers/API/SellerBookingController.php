<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingConfirmedMail;
use App\Mail\BookingCancelledMail;
use Illuminate\Support\Facades\Mail;

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
        try {
            $booking = Booking::with(['property', 'user'])->findOrFail($id);

            if (!$booking->property || $booking->property->seller_id !== auth()->id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $booking->status = 'confirmed';
            $booking->save();

            $property = $booking->property;
            $property->status = 'sold';
            $property->save();

            // Send confirmation email to the customer
            try {
                Mail::to($booking->user->email)->send(new BookingConfirmedMail($booking));
                
                return response()->json([
                    'message' => 'Booking confirmed, property marked as sold, and confirmation email sent to customer'
                ]);
            } catch (\Exception $e) {
                Log::error('Error sending confirmation email: ' . $e->getMessage());
                
                return response()->json([
                    'message' => 'Booking confirmed and property marked as sold, but there was an issue sending the confirmation email'
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error confirming booking: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while confirming the booking'], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $booking = Booking::with(['property', 'user'])->findOrFail($id);

            if (!$booking->property || $booking->property->seller_id !== auth()->id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $booking->status = 'cancelled';
            $booking->save();

            // Send cancellation email to the customer
            try {
                Mail::to($booking->user->email)->send(new BookingCancelledMail($booking));
                
                return response()->json([
                    'message' => 'Booking cancelled successfully and notification email sent to customer',
                    'data' => [
                        'booking_id' => $booking->id,
                        'status' => $booking->status
                    ]
                ]);
            } catch (\Exception $e) {
                Log::error('Error sending cancellation email: ' . $e->getMessage());
                
                return response()->json([
                    'message' => 'Booking cancelled successfully, but there was an issue sending the notification email',
                    'data' => [
                        'booking_id' => $booking->id,
                        'status' => $booking->status
                    ]
                ]);
            }

        } catch (\Exception $e) {
            \Log::error("Error cancelling booking: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }

}
