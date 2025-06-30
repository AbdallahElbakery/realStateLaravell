<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::all();
        return NotificationResource::collection($notifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return response()->json(["message" => "this notification is not found"], 404);
        }
        return new NotificationResource($notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return response()->json(["message" => "this notification id not found"], 404);
        }
        $notification->update([
            "is_read" => true,
        ]);
        return response()->json(["message" => "Notification marked as read"], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return response()->json(data: ["message" => "this notification is not found"]);
        }
        $notification->delete();
        return response()->json(["message" => "deleted successfully"], 200);
    }
    public function markallasread()
    {
        $notifications = Notification::all();
        foreach($notifications as $notification){
        $notification->update([
            "is_read" => true,
        ]);
        }
        return response()->json(["message" => "Notifications marked all as read"], 200);
  
    }
}

