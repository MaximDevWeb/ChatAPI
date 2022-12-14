<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\MessageCreated;
use App\Events\MessageDeleted;
use App\Events\MessageUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $messages = Message::where('room_id', $room_id)
            ->with('file')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return response()->json([
            'status' => 'success',
            'messages' => MessageResource::collection($messages)->response()->getData(true),
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
            'text' => 'string',
        ]);

        $message = new Message();
        $message->text = $request->text;
        $message->type = $request->type ?? 'TEXT';
        $message->user_id = Auth::id();
        $message->room_id = $room_id;
        $message->file_id = $request->file_id;
        $message->save();

        broadcast(new MessageCreated(
            new MessageResource($message)
        ));

        return response()->json([
            'status' => 'success'
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

        broadcast(new MessageUpdated(
            new MessageResource($message)
        ));

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
        $file = $message->file;

        if ($file) {
            Storage::delete($file->path);
            $file->delete();
        }

        $message->delete();

        broadcast(new MessageDeleted($room_id, $id));

        return response()->json([
            'status' => 'success',
        ]);
    }
}
