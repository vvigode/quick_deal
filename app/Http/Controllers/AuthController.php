<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Контроллер аутентификации пользователей.
 */
class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Проверка, если пользователь не авторизован и если уже есть пользователь в базе данных
        if (!auth()->check() && User::count() > 0) {
            return response()->json(['error' => 'Нельзя создать больше одного пользователя'], 403);
        }
        
        // Валидация данных запроса
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        // Создание нового пользователя
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Авторизация пользователя
        Auth::login($user);

        // Генерация токена аутентификации
        $token = $user->createToken('auth_token')->plainTextToken;

        // Логирование успешной регистрации
        Log::info('Пользователь зарегистрирован успешно');

        // Возвращение токена аутентификации
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Авторизация существующего пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Получение email и пароля из запроса
        $credentials = $request->only('email', 'password');

        // Попытка авторизации пользователя
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            // Логирование успешной авторизации
            Log::info('Пользователь авторизован успешно');

            // Возвращение токена аутентификации
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // Логирование неудачной авторизации
        Log::warning('Неудачная попытка авторизации');

        // Возвращение ошибки авторизации
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}