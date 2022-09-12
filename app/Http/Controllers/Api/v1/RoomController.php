<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Participant;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * Получаем чат с твыбранным контактом,
     * если такого нет создаем новый.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function getOrStorePersonal(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'integer|required'
        ]);

        $room = Room::with('participants')
            ->where('type', 'personal')
            ->whereIn('id', Participant::select('room_id')
                ->where('user_id', $request->id)
                ->whereIN('room_id', Participant::select('room_id')
                    ->where('user_id', Auth::id())))
            ->first();

        if (!$room) {
            $room = $this->store([$request->id]);
        }

        return response()->json([
            'status' => 'success',
            'room' => new RoomResource($room),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function storeGroup(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'string|required',
            'avatar' => 'file|required',
            'participants' => 'array|required'
        ]);

        $room = $this->store(
            $request->participants,
            $request->name,
            $request->file('avatar')
        );

        return response()->json([
            'status' => 'success',
            'room' => new RoomResource($room),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $participants
     * @param null $name
     * @param null $avatar
     * @return Room
     */
    private function store($participants, $name = null,  $avatar = null): Room
    {

        $room = new Room();
        $room->type = count($participants) > 1 ? 'group' : 'personal';
        $room->name = $name ?: '';

        if ($avatar) {
            $path = $avatar->storePublicly('avatars/custom');
            $link = Storage::url($path);

            $room->avatar_path = $path;
            $room->avatar_link = $link;
        }

        $room->save();

        $participants[] = Auth::id();

        foreach ($participants as $item) {
            $participant = new Participant();
            $participant->user_id = $item;
            $participant->room_id = $room->id;
            $participant->save();
        }

        return $room;
    }
}
