<?php

// Используем фасады для роутинга и контроллеров
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

// Группа роутов, защищенных middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {
    // Ресурсный роут для задач, использующий контроллер TaskController
    Route::apiResource('tasks', TaskController::class);
});

// Роут для авторизации, использующий метод login контроллера AuthController
Route::post('login', [AuthController::class, 'login']);

// Роут для регистрации, использующий метод register контроллера AuthController
Route::post('register', [AuthController::class, 'egister']);

// Роут, возвращающий информацию о текущем пользователе, если он авторизован
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // Возвращаем информацию о текущем пользователе
    return $request->user();
});