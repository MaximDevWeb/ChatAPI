<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParticipantResource;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ParticipantsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $room_id
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(int $room_id, Request $request): JsonResponse
    {
        $request->validate([
            'participants' => 'required|array',
        ]);

        $old_participants = Participant::where('room_id', $room_id)
            ->get()
            ->pluck('user_id')
            ->toArray();

        $new_participants = array_diff($request->participants, $old_participants);

        foreach ($new_participants as $item) {
            $participan = new Participant();
            $participan->room_id = $room_id;
            $participan->user_id = $item;
            $participan->save();
        }

        return response()->json([
            'status' => 'success',
            'participants' => ParticipantResource::collection(
                Participant::where('room_id', $room_id)->get()
            ),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $room_id
     * @param  int  $id
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function destroy(int $room_id, int $id): JsonResponse
    {
        $participant = Participant::where('room_id', $room_id)
            ->where('user_id', $id)
            ->first();

        if (! $participant) {
            throw ValidationException::withMessages([
                'participant' => ['Пользователь в чате не найдет'],
            ]);
        }

        $participant->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
