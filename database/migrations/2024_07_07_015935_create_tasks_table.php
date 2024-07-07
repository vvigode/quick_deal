<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Создание таблицы задач.
 */
class CreateTasksTable extends Migration
{
    /**
     * Создание таблицы задач.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            // Создание поля идентификатора
            $table->id();
            // Создание поля заголовка задачи
            $table->string('title');
            // Создание поля описания задачи (необязательное)
            $table->text('description')->nullable();
            // Создание поля статуса задачи (pending, in_progress, completed)
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            // Создание поля дедлайна задачи (необязательное)
            $table->timestamp('deadline')->nullable();
            // Создание полей создания и обновления задачи
            $table->timestamps();
            // Создание поля удаления задачи (soft delete)
            $table->softDeletes();
        });
    }

    /**
     * Удаление таблицы задач.
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}