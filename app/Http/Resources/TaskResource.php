<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Класс ресурса для представления задачи в формате JSON.
 */
class TaskResource extends JsonResource
{
    /**
     * Преобразует ресурс в массив для представления в формате JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // Идентификатор задачи
            'id' => $this->id,
            // Заголовок задачи
            'title' => $this->title,
            // Описание задачи
            'description' => $this->description,
            // Статус задачи
            'status' => $this->status,
            // Deadline задачи
            'deadline' => $this->deadline,
            // Дата создания задачи
            'created_at' => $this->created_at,
            // Дата обновления задачи
            'updated_at' => $this->updated_at
        ];
    }
}