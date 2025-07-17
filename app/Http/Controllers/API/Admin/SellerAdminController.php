<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSeller;
use App\Http\Resources\SellerResource;

class SellerAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::all();
        $allSeller = SellerResource::collection($sellers);
        return response()->json(["message" => 'returned all sellers for admin', "allsellers" => $allSeller]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeller $request)
    {
        $seller = Seller::create($request->validated());
        $createdSeller = new SellerResource($seller);
        return response()->json(["Message" => "Created successflly", "created seller" => $createdSeller], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seller = Seller::find($id);
        return response()->json(["seller" => $seller], 200);
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
    public function destroy(string $id)
    {
        $seller = Seller::find($id);
        if (!$seller) {
            return response()->json(["message" => "this seller is not found"], 404);
        }
        $seller->delete();
        return response()->json(["message" => "deleted seller successfully by admin"], 200);
    }
}
