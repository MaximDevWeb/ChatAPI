<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Api для регистрации на сайте
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'login' => 'required|unique:users,login',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'submit' => 'accepted'
        ]);

        User::create($request->all());

        return response()->json(['status' => 'success']);
    }

    /**
     * Api для автоирзации на сайте
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'token' => $user->createToken('auth')->plainTextToken
            ]);
        }

        throw ValidationException::withMessages([
            'login' => ['Логин и пароль не совпадают'],
        ]);
    }

    public function auth_user(): JsonResponse
    {
        return response()->json([
            'user' => Auth::user()
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json(['status' => 'success']);
    }
}
