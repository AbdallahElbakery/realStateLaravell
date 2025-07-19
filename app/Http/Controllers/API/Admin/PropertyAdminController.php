<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Http\Resources\PropertyResource;
use App\Http\Requests\StoreProperty;
use App\Http\Requests\UpdateProperty;
use App\Models\Address;

class PropertyAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        $allProperties = PropertyResource::collection($properties);
        return response()->json(["message" => "returned successfully", "properties" => $allProperties]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProperty $request)
    {
        $address = Address::create([
            "full_address" => $request->location,
            "country" => $request->country,
            "city" => $request->city,
        ]);
        $propertyData = $request->validated();
        $propertyData['address_id'] = $address->id;

        $property = Property::create($propertyData);
        $createdProperty = new PropertyResource($property);
        return response()->json(["message" => "property created successfuly", "new property" => $createdProperty], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(["message" => "this property not found with id " . $id], 404);
        }

        $singleProperty = new PropertyResource($property);
        return response()->json(["message" => "returned successfully single property with id " . $id, "Property" => $singleProperty], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProperty $request, string $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(["message" => "not found this property to edit with id " . $id], 404);
        }

        $address = Address::find($property->address_id);

        $address->update([
            "city" => $request->city,
            "country" => $request->country,
            "full_address" => $request->location,
        ]);
        $property->update($request->validated());
        $updatedProperty = new PropertyResource($property);
        return response()->json(["message" => "successfully edited this property with id " . $id, "new property after edit " => $updatedProperty], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json(["message"=> "this property is not found"],404);
        }
        $property->delete();
        return response()->json(["message"=> "deleted successfully proeprty with id ".$id],200);
    }
}
