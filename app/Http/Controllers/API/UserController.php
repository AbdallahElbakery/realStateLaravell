<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function me()
    {
        $user = Auth::user()->load('address');
        return response()->json([
            "message" => "User data retrieved successfully",
            "user" => new UserResource(Auth::user()),
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUsers = User::all();
        return response()->json([
            "Message" => "Returned successflly",
            "All Users" => $allUsers
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json(["Message" => "Created successflly", "created user" => $user], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = Auth::user();
        // $user = User::find($user_id);
        if (!$user) {
            return response()->json(["msg" => "This User is not found"], 404);
        }
        // $seller=new SellerResource($singleUser);
        return response()->json(["Message" => "Returned successflly", 'User' => $user], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(["msg" => "This user is not found"], 404);
        }
        $user->update($request->validated());
        return response()->json(["Message" => "Updated successflly", 'User' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return response()->json(["msg" => "This user is not found"], 404);
        }
        $user->delete();
        return response()->json(['Message' => 'Deleted successfully!']);
    }
}
