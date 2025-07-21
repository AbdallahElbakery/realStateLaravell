<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;

class AdminProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        $address = Address::create([
        'city' => $request->city,
        'country' => $request->country
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'photo' => $request->photo,
            'location' => $request->$address,
            'role' => $request->role,
        ]);

        return response()->json(["message"=>"updated","newUser"=>$user]);
    }
}
