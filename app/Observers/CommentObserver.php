<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\CommentAddedNotification;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

/**
 * Класс, представляющий наблюдатель для модели комментария.
 * @package App\Observers Наблюдатели приложения.
 */
class CommentObserver
{
    /**
     * Обрабатывает событие создания комментария.
     *
     * @param \App\Models\Comment $comment объект добавленного комментария.
     * @return void
     */
    public function created(Comment $comment)
    {
        // Если в конфигурации указана отправка уведомлений и пользователь, добавивший комментарий, не авторизован
        if(config('app.enable_notifications') && !Auth::check()) {
            // Получаем список пользователей приложения
            $users = User::all();
            // Загружаем в комментарий данные о статье
            $comment->load('article');
            // Отправляем уведомления
            Notification::send($users, new CommentAddedNotification($comment->toArray()));
        }
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
