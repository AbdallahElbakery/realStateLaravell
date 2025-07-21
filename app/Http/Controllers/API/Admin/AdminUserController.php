<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Http\Resources\UserResource;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $allUsers = UserResource::collection($users);
        return response()->json(["allUsers" => $allUsers], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegisterRequest $request)
    {
        $address = Address::create([
            'city' => $request->city,
            'country' => $request->country
        ]);
        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'photo' => $request->photo,
                'address_id' => $address->id,
                'role' => $request->role,
            ]
        );

        return response()->json(["message" => 'user created successfully', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $singlUser = new UserResource($user);
        return response()->json(['user' => $singlUser], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        // if($request->hasFile('photo')){
        //     $photo= $request->file('photo');
        //     $photoname=time().'_'.$photo->getClientOriginalName();
        //     $path=$photo->move(public_path('uploads'),$photoname);
        // }
        $address = Address::create([
            'city' => $request->city,
            'country' => $request->country
        ]);
        $user->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'photo' => $request->photo,
                'address_id' => $address->id,
                'role' => $request->role,
            ]
        );
        $user->save();
        return response()->json(['message' => 'user updated successfully', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'deleted successfully', 'user' => $user], 200);
    }
}
