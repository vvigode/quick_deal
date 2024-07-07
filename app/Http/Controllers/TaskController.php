<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest; // Используется для валидации данных при создании задачи
use App\Http\Requests\UpdateTaskRequest; // Используется для валидации данных при обновлении задачи
use App\Http\Resources\TaskResource; // Используется для форматирования ответа в формате ресурса задачи
use App\Models\Task; // Модель задачи
use Illuminate\Http\Request; // Используется для работы с запросами

class TaskController extends Controller
{
    /**
     * Получение списка задач с возможностью фильтрации по статусу и дате дедлайна
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        // Создаем запрос к модели задачи
        $query = Task::query();

        // Если в запросе передан параметр status, фильтруем задачи по статусу
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Если в запросе передан параметр deadline, фильтруем задачи по дате дедлайна
        if ($request->has('deadline')) {
            $query->whereDate('deadline', $request->input('deadline'));
        }

        // Возвращаем список задач в формате ресурса, с пагинацией
        return TaskResource::collection($query->paginate());
    }

    /**
     * Создание новой задачи
     *
     * @param StoreTaskRequest $request
     * @return TaskResource
     */
    public function store(StoreTaskRequest $request)
    {
        // Создаем новую задачу с валидированными данными из запроса
        $task = Task::create($request->validated());

        // Возвращаем созданную задачу в формате ресурса
        return new TaskResource($task);
    }

    /**
     * Получение информации о задаче
     *
     * @param Task $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        // Возвращаем задачу в формате ресурса
        return new TaskResource($task);
    }

    /**
     * Обновление задачи
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return TaskResource
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Обновляем задачу с валидированными данными из запроса
        $task->update($request->validated());

        // Возвращаем обновленную задачу в формате ресурса
        return new TaskResource($task);
    }

    /**
     * Удаление задачи
     *
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        // Удаляем задачу
        $task->delete();

        // Возвращаем ответ о том, что задача удалена
        return response()->json(['message' => 'Task deleted'], 204);
    }
}