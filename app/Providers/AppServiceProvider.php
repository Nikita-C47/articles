<?php

namespace App\Providers;

use App\Models\Comment;
use App\Observers\CommentObserver;
use Illuminate\Support\ServiceProvider;

/**
 * Класс, представляющий провайдер сервисов приложения.
 * @package App\Providers Провайдеры приложения.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Регистрирует сервисы приложения.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Загружает сервисы приложения.
     *
     * @return void
     */
    public function boot()
    {
        // Назначаем наблюдатель для модели комментария
        Comment::observe(CommentObserver::class);
    }
}
