<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\UserCreated;
use App\Events\ProfileUpdated;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Контроллер для предоставлиния Api
 * для регистрации и авторизации
 */
class AuthController extends Controller
{
    /**
     * Метод для регистрации на сайте
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

        $user = User::create($request->all());

        UserCreated::dispatch($user);

        return response()->json(['status' => 'success']);
    }

    /**
     * Метод для автоирзации на сайте
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

    /**
     * Метод для получение данных о пользователе после авторизации
     *
     * @return JsonResponse
     */
    public function auth_user(): JsonResponse
    {
        return response()->json([
            'user' => User::with(['profile', 'avatar'])->find(Auth::id())
        ]);
    }

    /**
     * Метод выхода из приложения
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json(['status' => 'success']);
    }
}
