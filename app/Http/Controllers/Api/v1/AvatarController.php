<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $avatar = Avatar::where('user_id', Auth::id())->first();

        $path = $request->file('avatar')->storePublicly('avatars/custom');
        $link = Storage::url($path);

        if ($avatar->type === Avatar::$CUSTOM_TYPE) {
            Storage::delete($avatar->path);
        }

        $avatar->type = Avatar::$CUSTOM_TYPE;
        $avatar->path = $path;
        $avatar->link = $link;
        $avatar->save();

        return response()->json([
            'status' => 'success',
            'avatar_link' => $link,
        ]);
    }
}
