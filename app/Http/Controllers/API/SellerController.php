<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeller;
use App\Http\Requests\UpdateSeller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Address;
use App\Http\Resources\SellerResource;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allSellers = Seller::all();
        $sellers = SellerResource::collection($allSellers);
        return response()->json(["Message" => "Returned successflly", "All sellers" => $sellers], 200);
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
    public function show(string $user_id)
    {
        // $seller = Seller::where('user_id',$user_id)->first();
        $user = User::find($user_id);
        $singleSeller = Seller::where('user_id', $user->id)->first();
        if (!$singleSeller) {
            return response()->json(["msg" => "This seller is not found"], 404);
        }
        $seller = new SellerResource($singleSeller);
        return response()->json(["Message" => "Returned successflly", 'Seller' => $seller], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeller $request, string $user_id)
    {
        $user = User::find($user_id);
        $seller = Seller::where('user_id', $user->id)->first();
        // dd($seller);
        if (!$seller) {
            return response()->json(["msg" => "This seller is not found"], 404);
        }
        $seller->update($request->validated());
        $updatedSeller = new SellerResource($seller);

        return response()->json(["Message" => "Updated successflly", 'Seller' => $updatedSeller], 200);
    }

    public function updateCompanyDetails(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $seller = Seller::where('user_id', $user->id)->first();
        if (!$seller) {
            return response()->json(['msg' => 'this seller is not found'], 404);
        }
        $seller->update([
            'company_name' => $request->company_name,
            'logo' => $request->logo,
            'about_company' => $request->about_company,
        ]);
        $updated = new SellerResource($seller);
        return response()->json(['message' => 'updated', 'updated successfully' => $updated]);
    }


    public function editPersonalInfo(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['msg' => 'this seller is not found'], 404);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'photo' => $request->photo,
        ]);
        $seller = Seller::where('user_id', $user->id)->first();
        
        $seller->update([
            'personal_id_image' => $request->personal_id_image
        ]);

        Address::where('id', $user->address_id)->update([
        'full_address' => $request->full_address,
        ]);
        
        $updated = new SellerResource($seller);
        return response()->json(['message' => 'updated', 'updated successfully' => $updated]);
    }


    public function changePassword(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $cuurentPass = $user->password;
        $user->update([
            'password' => $request->password,
        ]);
        $seller = Seller::where('user_id', $user->id)->first();
        $updatedpass = new SellerResource($seller);
        return response()->json(["current password" => $cuurentPass, 'message' => 'updated', 'password updated successfully' => $updatedpass]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id)
    {
        $seller = Seller::where('user_id', $user_id)->first();
        if (!$seller) {
            return response()->json(["msg" => "This seller is not found"], 404);
        }
        $seller->delete();
        return response()->json(['Message' => 'Deleted successfully!']);
    }
}
