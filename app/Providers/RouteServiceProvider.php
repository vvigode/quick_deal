<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Класс провайдера маршрутизации для приложения.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Путь к маршруту "домашней" страницы приложения.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Определение связей моделей маршрутов, фильтров шаблонов и т.д.
     *
     * @return void
     */
    public function boot()
    {
        // Конфигурация ограничений скорости запросов
        $this->configureRateLimiting();

        // Определение групп маршрутов
        $this->routes(function () {
            // Группа API-маршрутов
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            // Группа веб-маршрутов
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Конфигурация ограничений скорости запросов для приложения.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        // Ограничение скорости запросов для API
        RateLimiter::for('api', function (Request $request) {
            // Ограничение 60 запросов в минуту для каждого пользователя или IP-адреса
            return Limit::perMinute(60)->by(optional($request->user())->id?: $request->ip());
        });
    }
}