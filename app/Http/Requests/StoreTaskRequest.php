<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Определяет, имеет ли пользователь право на выполнение запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Возвращает массив правил валидации для полей формы.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'deadline' => 'nullable|date'
        ];
    }
}