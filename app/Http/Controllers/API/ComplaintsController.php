<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use App\Models\User;
use App\Http\Requests\StoreComplaints;
use App\Http\Requests\UpdateComplaint;


class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        $complaints = Complaint::all();
        return ComplaintResource::collection($complaints);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaints $request)
    {
        $complaints = Complaint::create($request->validated());
        return response()->json([
            "message" => "created successfully",
            "new complaint" => $complaints
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complaint = Complaint::find($id);
        if(!$complaint){
            return response()->json(["message"=>"this complaint is not found"],404);
        }
        return new ComplaintResource($complaint);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaint $request, string $id)
    {
        $complaint = Complaint::find($id);
          if(!$complaint){
            return response()->json(["message"=>"this complaint is not found"],404);
        }
        $complaint->update($request->validated());
        return response()->json([
            "message"=> "updated successfully",
            "complaint after updation"=> $complaint
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $complaint = Complaint::find($id);
        if(!$complaint){
            return response()->json(["message"=> "this complaint is not found"],404);
        }
        $complaint->delete();
        return response()->json(["message"=>"deleted successfully"],200);
    }
}
