<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;

use App\Models\User;

use App\Models\Address;

class AdminRegisterController extends Controller
{
    public function registerAdmin(UserRegisterRequest $request)
    {
        $address = Address::create([
            'city' => $request->city,
            'country' => $request->country,
        ]);

        // if ($request->hasFile('photo')) {
        //     $photo = $request->file('photo');
        //     $photoname = time() . '_' . $photo->getClientOriginalName();
        //     $photo->move(public_path('uploads'), $photoname);
        // }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => $request->photo,
            'address_id' => $address->id,
            'phone' => $request->phone,
            'role' => 'admin',
        ]);
        $user->admin()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'new admin user created successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
