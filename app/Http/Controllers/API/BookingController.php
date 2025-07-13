<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Http\Resources\PropertyResource;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $userId = auth()->id();
            $bookings = Booking::with('property')
                ->where('user_id', $userId)
                ->get();

            $bookings->transform(function ($booking) {
                $booking->property = $booking->property ? (new PropertyResource($booking->property))->toArray(request()) : null;
                return $booking;
            });

            return response()->json([
                'message' => 'Bookings retrieved successfully',
                'bookings' => $bookings,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error loading bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'property_id' => 'required|exists:properties,id',
                'suggested_price' => 'required|numeric|min:0',
            ]);

            //Check if the booking exists
            $existingBooking = Booking::where('user_id', auth()->id())
                ->where('property_id', $request->property_id)
                ->first();

            if ($existingBooking) {
                return response()->json([
                    'message' => 'You already have an offer for this property'
                ], 400);
            }

            //Check if the property available
            $property = \App\Models\Property::findOrFail($request->property_id);
            if ($property->status !== 'available') {
                return response()->json([
                    'message' => 'This property is not available for booking'
                ], 400);
            }

            //create new bokking
            $booking = Booking::create([
                'user_id' =>  auth()->id(),
                'property_id' => $request->property_id,
                'suggested_price' => $request->suggested_price,
                'status' => 'pending',
            ]);

            // Load the property relationship
            $booking->load('property');

            return response()->json([
                'message' => 'Booking created successfully',
                'booking' => $booking
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => ' Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $booking = Booking::with(['property', 'user'])->findOrFail($id);

            return response()->json([
                'message' => 'Booking retrieved successfully',
                'booking' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Booking not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->update($request->only('suggested_price'));

            // Load the property relationship after update
            $booking->load('property');

            return response()->json([
                'message' => 'Booking updated successfully',
                'booking' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();

            return response()->json([
                'message' => 'Booking deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
