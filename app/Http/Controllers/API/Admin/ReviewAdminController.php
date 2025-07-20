<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
class ReviewAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        $allReviews = ReviewResource::collection($reviews);
        return response()->json(["message" => "returned all reviews", "allReviews" => $allReviews]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(["message" => "this review is not found"], 404);
        }
        $reviewDetails = new ReviewResource($review);
        return response()->json(["message" => "returned review", "review" => $reviewDetails]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(["message" => "this review is not found"], 404);
        }
        $review->delete();
        return response()->json(["message" => "deleted sucsessfully review -> '" . $review->comment . "'", "review" => $review]);
    }
}
