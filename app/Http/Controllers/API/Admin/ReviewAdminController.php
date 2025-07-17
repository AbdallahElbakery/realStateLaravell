<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();
        return response()->json(["message" => "returned all reviews", "all reviews" => $reviews]);
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
        return response()->json(["message" => "returned review", "review" => $review]);
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
