# Task Manager

Task Manager - это простое приложение для управления задачами, созданное с использованием Laravel. Оно включает создание, чтение, обновление и удаление задач, а также возможность поиска по статусу и крайнему сроку. Проект демонстрирует хорошие практики архитектуры, безопасности, использования ООП и тестирования.

## Установка

1. Клонируйте репозиторий:
    ```bash
    git clone https://github.com/your-username/task-manager.git
    cd task-manager
    ```

2. Установите зависимости:
    ```bash
    composer install
    ```

3. Скопируйте `.env.example` в `.env` и настройте параметры подключения к базе данных:
    ```bash
    cp .env.example .env
    ```

4. Создайте базу данных и выполните миграции:
    ```bash
    php artisan migrate
    ```

5. Сгенерируйте ключ приложения:
    ```bash
    php artisan key:generate
    ```

6. Запустите сервер разработки:
    ```bash
    php artisan serve
    ```

## API эндпоинты

### Добавление пользователя

**Request:**
```bash
POST /api/register
```
**Headers:**

```json
{
  "Content-Type": "application/json"
}
```
**Body:**

```json
{
  "name":"John Doe",
  "email":"johndoe@example.com",
  "password":"password",
  "password_confirmation":"password"
}
```
**Response:**

```json
{
    "access_token": "your-generated-token",
    "token_type": "Bearer"
}
```

### Вход/Получение токена

**Request:**
```bash
POST /api/login
```
**Headers:**

```json
{
  "Content-Type": "application/json"
}
```
**Body:**

```json
{
  "email":"johndoe@example.com",
  "password":"password"
}
```
**Response:**

```json
{
  "access_token": "your-generated-token",
  "token_type": "Bearer"
}
```

### Создание новой задачи

**Request:**
```bash
POST /api/tasks
```
**Headers:**

```json
{
  "Content-Type": "application/json",
  "Authorization": "Bearer {your-token}"
}
```
**Body:**

```json
{
  "title": "Новая задача",
  "description": "Описание",
  "status": "pending",
  "deadline": "2024-12-31"
}
```
**Response:**

```json
{
  "id": 1,
  "title": "Новая задача",
  "description": "Описание",
  "status": "pending",
  "deadline": "2024-12-31T00:00:00.000000Z",
  "created_at": "2024-07-06T00:00:00.000000Z",
  "updated_at": "2024-07-06T00:00:00.000000Z"
}
```
### Получение списка задач
**Request:**

```bash
GET /api/tasks
```
**Headers:**

```json
{
  "Authorization": "Bearer {your-token}"
}
```
**Response:**

```json
[
  {
    "id": 1,
    "title": "Новая задача",
    "description": "Описание",
    "status": "pending",
    "deadline": "2024-12-31T00:00:00.000000Z",
    "created_at": "2024-07-06T00:00:00.000000Z",
    "updated_at": "2024-07-06T00:00:00.000000Z"
  }
]
```
### Получение задачи по ID
**Request:**

```bash
GET /api/tasks/{id}
```
**Headers:**

```json
{
  "Authorization": "Bearer {your-token}"
}
```
**Response:**

```json
{
  "id": 1,
  "title": "Новая задача",
  "description": "Описание",
  "status": "pending",
  "deadline": "2024-12-31T00:00:00.000000Z",
  "created_at": "2024-07-06T00:00:00.000000Z",
  "updated_at": "2024-07-06T00:00:00.000000Z"
}
```
### Обновление задачи
**Request:**

```bash
PUT /api/tasks/{id}
```
**Headers:**

```json
{
  "Content-Type": "application/json",
  "Authorization": "Bearer {your-token}"
}
```
**Body:**

```json
{
  "title": "Изменённая задача",
  "status": "in_progress"
}
```
**Response:**

```json
{
  "id": 1,
  "title": "Изменённая задача",
  "description": "Изменённое описание",
  "status": "in_progress",
  "deadline": "2024-12-31T00:00:00.000000Z",
  "created_at": "2024-07-06T00:00:00.000000Z",
  "updated_at": "2024-07-06T00:00:00.000000Z"
}
```
### Удаление задачи
**Request:**

```bash
DELETE /api/tasks/{id}
```
**Headers:**

```json
{
  "Authorization": "Bearer {your-token}"
}
```
**Response:**

```json
{
  "message": "Задача удалена"
}
```
### Поиск задач по статусу
**Request:**

```bash
GET /api/tasks?status=in_progress
```
**Headers:**

```json
{
  "Authorization": "Bearer {your-token}"
}
```
**Response:**

```json
[
  {
    "id": 1,
    "title": "Изменённая задача",
    "description": "Изменённое описание",
    "status": "in_progress",
    "deadline": "2024-12-31T00:00:00.000000Z",
    "created_at": "2024-07-06T00:00:00.000000Z",
    "updated_at": "2024-07-06T00:00:00.000000Z"
  }
]
```
### Поиск задач по крайнему сроку
**Request:**

```bash
GET /api/tasks?deadline=2024-12-31
```
**Headers:**

```json
{
  "Authorization": "Bearer {your-token}"
}
```
**Response:**

```json
[
  {
    "id": 1,
    "title": "Изменённая задача",
    "description": "Изменённое описание",
    "status": "in_progress",
    "deadline": "2024-12-31T00:00:00.000000Z",
    "created_at": "2024-07-06T00:00:00.000000Z",
    "updated_at": "2024-07-06T00:00:00.000000Z"
  }
]
```
### Тестирование
**Для запуска тестов выполните команду:**

```bash
php artisan test
```