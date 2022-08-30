<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Participant;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function myRooms(): JsonResponse
    {
        $rooms = Room::my()->get();

        return response()->json([
            'status' => 'success',
            'rooms' => RoomResource::collection($rooms),
        ]);
    }

    /**
     * @param  int  $room_id
     * @return JsonResponse
     */
    public function room(int $room_id): JsonResponse
    {
        $room = Room::with('participants')->findOrFail($room_id);

        return response()->json([
            'status' => 'success',
            'room' => new RoomResource($room),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'participants' => 'required|array',
            'name' => 'string',
            'avatar' => 'file',
        ]);

        $room = new Room();
        $room->type = count($request->participants) > 1 ? 'group' : 'personal';
        $room->name = $request->name ?: '';

        if ($request->file('avatar')) {
            $path = $request->file('avatar')->storePublicly('avatars/custom');
            $link = Storage::url($path);

            $room->avatar_path = $path;
            $room->avatar_link = $link;
        }

        $room->save();

        $participants = $request->participants;
        $participants[] = Auth::id();

        foreach ($participants as $item) {
            $participant = new Participant();
            $participant->user_id = $item;
            $participant->room_id = $room->id;
            $participant->save();
        }

        return response()->json([
            'status' => 'success',
            'room' => new RoomResource($room),
        ]);
    }
}
