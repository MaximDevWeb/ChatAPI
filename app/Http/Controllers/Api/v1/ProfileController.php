<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'birthday' => 'string|nullable',
            'city' => 'string|nullable'
        ]);

        $profile = Profile::where('user_id', Auth::id())->first();

        $profile->update($request->all());

        return response()->json([
            'status' => 'success',
        ]);
    }
}
