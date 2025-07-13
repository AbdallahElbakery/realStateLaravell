<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use App\Models\Seller;
use App\Models\Address;
use App\Http\Resources\SellerResource;
use App\Http\Requests\StoreProperty;
use App\Http\Requests\StoreSeller;
use App\Http\Requests\UpdateSeller;
use App\Http\Requests\StoreOwnProperty;
use App\Http\Requests\UpdateOwnProperty;
use App\Http\Requests\UpdateSellerPass;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function index()
    {
        $allSellers = Seller::all();
        $sellers = SellerResource::collection($allSellers);
        return response()->json(["Message" => "Returned successflly", "All sellers" => $sellers], 200);
    }


    public function store(StoreSeller $request)
    {
        $seller = Seller::create($request->validated());
        $createdSeller = new SellerResource($seller);
        return response()->json(["Message" => "Created successflly", "created seller" => $createdSeller], 201);
    }


    public function show()
    {
        $user = auth()->user();
        $singleSeller = Seller::where('user_id', $user->id)->first();
        if ($user->role != 'seller') {
            return response()->json(['message' => 'this user is not a seller'], 404);
        }
        if (!$singleSeller) {
            return response()->json(["msg" => "This seller is not found"], 404);
        }
        $seller = new SellerResource($singleSeller);
        return response()->json(["Message" => "Returned successflly", 'Seller' => $seller], 200);
    }


    public function update(UpdateSeller $request)
    {
        $user = auth()->user();
        $seller = Seller::where('user_id', $user->id)->first();
        if (!$seller) {
            return response()->json(["msg" => "This seller is not found"], 404);
        }
        $seller->update($request->validated());
        $updatedSeller = new SellerResource($seller);

        return response()->json(["Message" => "Updated successflly", 'Seller' => $updatedSeller], 200);
    }

    public function updateCompanyDetails(Request $request)
    {
        $user = auth()->user();
        $seller = Seller::where('user_id', $user->id)->first();
        if (!$seller) {
            return response()->json(['msg' => 'this seller is not found'], 404);
        }
        $seller->update([
            'company_name' => $request->company_name,
            // 'logo' => $request->logo,
            'about_company' => $request->about_company,
        ]);
        $updated = new SellerResource($seller);
        return response()->json(['message' => 'updated', 'updated successfully' => $updated]);
    }

    public function changePassword(UpdateSellerPass $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['msg' => 'User not found'], 404);
        }

        if ($request->current_password !== $user->password) {
            return response()->json(['msg' => 'Current password is incorrect'], 422);
        }

        if ($request->newPass !== $request->confirmPassword) {
            return response()->json(['msg' => 'New password and confirmation do not match'], 422);
        }

        $user->update([
            'password' => $request->newPass,
        ]);

        return response()->json([
            'message' => '✅ Password updated successfully',
        ], 200);
    }

    public function editPersonalInfo(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['msg' => 'this seller is not found'], 404);
        }

        // $path = $request->file('photo')->store('properties', 'public');
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            // 'photo' => $path,
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




    public function addOwnProperty(StoreOwnProperty $request)
    {
        $user = auth()->user();
        $seller = Seller::find($user->id);
        if (!$seller) {
            return response()->json(['msg' => 'this seller is not existed'], 404);
        }
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
            $validated['image'] = $path;
        }
        $validated['seller_id'] = $seller->user_id;
        Property::create($validated);
        return response()->json(["msg" => "added new property owned to seller " . $seller->user_id], 201);
    }

    public function updateOwnProperty(UpdateOwnProperty $request, $prop_id)
    {
        $user = auth()->user();
        $seller = Seller::where('user_id', $user->id)->first();
        $property = Property::where('seller_id', $user->id)->where('id', $prop_id)->first();
        if (!$seller) {
            return response()->json(['msg' => 'this seller is not existed'], 404);
        }
        if (!$property) {
            return response()->json(['msg' => 'this property not owned to this seller'], 404);
        }

        $property->update($request->validated());
        return response()->json(["msg" => "updated property with id " . $property->id . " owned to seller " . $seller->user_id, "Propert" => $property], 200);
    }


    public function getOwnProperty($prop_id)
    {
        $user = auth()->user();
        $prop = Property::where('seller_id', $user->id);
        $property = $prop->where('id', $prop_id)->first();
        if (!$property) {
            return response()->json(['msg' => 'this property not found'], 404);
        }
        return response()->json(["Property" => $property], 200);
    }

    public function deleteOwnProperty($prop_id)
    {
        $user= auth()->user();
        $property = Property::where('seller_id', $user->id);
        $propertyId = $property->where('id', $prop_id)->first();
        if (!$propertyId) {
            return response()->json(['msg' => 'this property is not found'], 404);
        }
        $propertyId->delete();
        return response()->json('deleted');
    }

    public function destroy()
    {
        $user = auth()->user();
        $seller = Seller::where('user_id', $user->id)->first();
        if (!$seller) {
            return response()->json(["msg" => "This seller is not found"], 404);
        }
        $seller->delete();
        return response()->json(['Message' => 'Deleted successfully!']);
    }
}
