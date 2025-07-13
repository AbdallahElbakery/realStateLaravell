<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \App\Models\Review::with(['user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'seller_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($data);
        return response()->json($review->load(['user']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = Review::findOrFail($id);
        return $review->load(['user', 'seller']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $review = Review::findOrFail($id);
        $data = $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($data);
        return response()->json($review->load(['user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response()->json(['message' => 'Deleted']);
    }

    /**
     * Get reviews by seller ID
     */
    public function getReviewsBySeller($sellerId)
    {
        try {
            // التحقق من وجود البائع
            $seller = User::find($sellerId);
            if (!$seller) {
                return response()->json(['error' => 'Seller not found'], 404);
            }

            // جلب المراجعات المرتبطة بالبائع مع معلومات المستخدم
            $reviews = Review::where('seller_id', $sellerId)
                ->with(['user'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($reviews);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching reviews'], 500);
        }
    }
}
