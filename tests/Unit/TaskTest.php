<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

/**
 * Тестирование модели Task
 */
class TaskTest extends TestCase
{
    /**
     * Тестирование создания задачи
     */
    public function test_can_create_task()
    {
        // Получение пользователя по электронной почте
        $user = User::whereEmail('johndoe@example.com')->first();

        // Если пользователь не найден, создаем его
        if (!$user) {
            $user = User::factory()->create([
                'email' => 'johndoe@example.com',
                'password' => Hash::make('password') // Хешируем пароль
            ]);
        }

        // Авторизуем пользователя с помощью Sanctum
        Sanctum::actingAs($user);

        // Данные для создания задачи
        $taskData = [
            'title' => 'Тестовая задача',
            'description' => 'Описание Тестовой задачи',
            'status' => 'pending',
            'deadline' => '2024-12-31'
        ];

        // Отправляем POST-запрос на создание задачи
        $response = $this->postJson('/api/tasks', $taskData);

        // Проверяем статус ответа и содержимое JSON
        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Тестовая задача');
    }
}