<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class AdminProfileController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $userDetails = new UserResource($user);
        return response()->json(["message" => "returned profile", "profile" => $userDetails], 200);
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        $address = Address::create([
            'city' => $request->city,
            'country' => $request->country
        ]);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoname = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads'), $photoname);
            // $user->photo = $photoname;
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'photo' => $photoname,
            'address_id' => $address->id,
            'role' => $request->role,
        ]);
    }
        $userDetails = new UserResource($user);
        return response()->json(["message" => "updated", "newUser" => $userDetails]);
    }
}
