<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SellerRegisterRequest;
use App\Models\User;
use App\Models\Seller;
use App\Models\Address;

class SellerRegisterController extends Controller
{
    public function register(SellerRegisterRequest $request)
    {

        $address = Address::create([
            'city' => $request->city,
            'country' => $request->country,
        ]);

         if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads'), $photoName);
        } else {
            $photoName = null;
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'photo' => $photoName,
            'address_id' => $address->id,
            'role' => 'seller',
        ]);

        $user->seller()->create([
            'company_name' => $request->company_name,
            'logo' => $request->logo,
            'personal_id_image' => $request->personal_id_image,
            'status' => 'inactive', // Default status for new sellers
        ]);

        $user->load('seller','address');

        $token = $user->createToken('auth_token')->plainTextToken;
        // Return a response
        return response()->json([
                'message' => 'Seller registered successfully',
                'user' => $user,
                'token' =>$token
            ], 201);
    }
}

