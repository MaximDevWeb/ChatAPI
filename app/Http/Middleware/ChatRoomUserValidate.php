<?php

namespace App\Http\Middleware;

use App\Models\Participant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ChatRoomUserValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next)
    {
        $participant = Participant::where('room_id', $request->room_id)
            ->where('user_id', Auth::id())
            ->first();

        if (! $participant) {
            throw ValidationException::withMessages([
                'access' => ['Это не ваш чат'],
            ]);
        }

        return $next($request);
    }
}
