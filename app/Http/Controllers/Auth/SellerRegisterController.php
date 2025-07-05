<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SellerRegisterRequest;

use App\Models\User;
use App\Models\Seller;

class SellerRegisterController extends Controller
{
    public function register(SellerRegisterRequest $request)
    {
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'photo' => $request->photo,
            'address_id' => $request->address_id,
            'role' => 'seller', 
        ]);
        
        $user->seller()->create([
            'company_name' => $request->company_name,
            'logo' => $request->logo,
            'personal_id_image' => $request->personal_id_image,
            'status' => 'inactive', // Default status for new sellers
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        // Return a response
        return response()->json(['message' => 'Seller registered successfully', 'user' => $user ,'SellerInfo'=>$user->seller, 'token' =>$token], 201);
    }
}

