<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;

class UserRegisterController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'photo' => $request->photo,
            'address_id' => $request->address_id,
            'role' => 'user', // Default role for user registration
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        // Return a response
        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' =>$token], 201);
    }
}
