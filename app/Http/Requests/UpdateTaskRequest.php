<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс для валидации данных при обновлении задачи
 */
class UpdateTaskRequest extends FormRequest
{
    /**
     * Авторизация запроса
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Правила валидации для полей формы
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'ometimes|required|string|max:255',
            'description' => 'nullable|string',
            'tatus' => 'ometimes|required|in:pending,in_progress,completed',
            'deadline' => 'nullable|date'
        ];
    }
}