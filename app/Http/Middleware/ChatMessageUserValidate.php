<?php

namespace App\Http\Middleware;

use App\Models\Message;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ChatMessageUserValidate
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
        if (! $request->message) {
            return $next($request);
        }

        $message = Message::findOrFail($request->message);

        if ($message->user_id != Auth::id()) {
            throw ValidationException::withMessages([
                'access' => ['Это не ваше сообщение'],
            ]);
        }

        return $next($request);
    }
}
