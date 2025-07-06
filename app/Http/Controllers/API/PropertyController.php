<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Address;
use App\Models\User;
use App\Http\Resources\PropertyResource;
use App\Http\Requests\StoreProperty;
use App\Http\Requests\UpdateProperty;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        $allProperties = PropertyResource::collection($properties);
        return response()->json(["message" => "returned successfully all properties", "data" => $allProperties], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProperty $request)
    {
        $property = Property::create($request->validated());
        $createdProperty = new PropertyResource($property);
        return response()->json(["message" => "property created successfuly", "new property" => $createdProperty], 200);
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

        $property->update($request->validated());

        $address = Address::where('id', $property->address_id)->first();
        $address->update([
            "location" => $request->location,
            "city" => $request->addcity,
            "country" => $request->country,
        ]);

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
            return response()->json(["message" => "not fond this property with id " . $id], 404);
        }

        $property->delete();
        $deletedProperty = new PropertyResource($property);

        return response()->json(["message" => "deleted successfully this property with id " . $id, "deleted property" => $deletedProperty], 200);
    }
}
