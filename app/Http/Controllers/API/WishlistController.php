<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist = Wishlist::all();
        $properties = $wishlist->properties;
        dd($properties);
        return response()->json(["message" => $wishlist]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id, $prop_id)
    {
        $user = User::find($id);
        $wishlist = Wishlist::where("user_id", $user->id);
        $propertyIds = $wishlist->pluck('property_id');
        if($propertyIds->contains($prop_id)){
        return response()->json(["message" => "this item is already in wishlist "]);
        }
        $wishlist->create([
            'user_id' => $user->id,
            'property_id' => $prop_id,
        ]);
        $propertyIds = $wishlist->pluck('property_id');
        $properties = Property::whereIn('id', $propertyIds)->get();
        return response()->json(["message" => "created ", "properties" => $properties]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $wishlistItems = Wishlist::where("user_id", $user->id);
        $propertyIds = $wishlistItems->pluck('property_id');
        $properties = Property::whereIn('id', $propertyIds)->get();

        return response()->json(["message" => $properties]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, $prop_id)
    {
        $user = User::find($id);
        $wishlist = Wishlist::where("user_id", $user->id);
        $propertyId = $wishlist->where('property_id', $prop_id);
        $propertyId->delete();
        return response()->json(['message' => 'deleted successfully'], 200);
    }
}
