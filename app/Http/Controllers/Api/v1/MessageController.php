<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $room_id
     * @return JsonResponse
     */
    public function index(int $room_id): JsonResponse
    {
        $messages = Message::where('room_id', $room_id)->get();

        return response()->json([
            'status' => 'success',
            'messages' => MessageResource::collection($messages),
        ]);
    }

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
            'text' => 'required|string',
        ]);

        $message = new Message();
        $message->text = $request->text;
        $message->user_id = Auth::id();
        $message->room_id = $room_id;
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => new MessageResource($message),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $room_id
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, int $room_id, int $id): JsonResponse
    {
        $request->validate([
            'text' => 'required|string',
        ]);

        $message = Message::find($id);
        $message->text = $request->text;
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => new MessageResource($message),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $room_id
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $room_id, int $id): JsonResponse
    {
        $message = Message::find($id);
        $message->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
