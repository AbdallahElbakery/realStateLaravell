<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user ||!Hash::check($request->password ,$user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }else{
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'Message'=> 'Login successful',
                'UserName' => $user->name,
                'Token' => $token,
            ]);
        }
    }
}
