<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddress;
use App\Http\Requests\UpdateAddress;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::all();
        return response()->json($addresses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddress $request)
    {
        $address = Address::create($request->validated());
        return response()->json(["Created " => $address], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $address = Address::find($id);
        if (!$address) {
            return response()->json(["message" => "this address is not found"], 404);
        }
        return response()->json([$address], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddress $request, string $id)
    {
        $address = Address::find($id);
        if (!$address) {
            return response()->json(["message" => "this address is not found"], 404);
        }
        $address->update($request->validated());
        return response()->json(["updated" => $address], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
