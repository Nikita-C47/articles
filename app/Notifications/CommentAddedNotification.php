<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Класс, представляющий уведомление о добавлении нового комментарий к статье.
 * @package App\Notifications Уведомления приложения.
 */
class CommentAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    /** @var array $comment массив с данными о комментарии. */
    private $comment;

    /**
     * Создает новый экземпляр класса.
     *
     * @param array $comment комментарий.
     */
    public function __construct(array $comment)
    {
        // Инициализируем поле
        $this->comment = $comment;
    }

    /**
     * Получает каналы доставки уведомления.
     *
     * @param mixed $notifiable уведомляемый объект.
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Получает представление уведомления в виде письма.
     *
     * @param mixed $notifiable уведомляемый объект.
     * @return \Illuminate\Notifications\Messages\MailMessage объект сообщения для отправки.
     */
    public function toMail($notifiable)
    {
        // Собираем сообщение
        return (new MailMessage)
                    ->subject('Новый комментарий к статье')
                    ->greeting('Здравствуйте! В сборнике статей появился новый комментарий.')
                    ->line('Подробности о комментарии:')
                    ->line('Статья: '.$this->comment['article']['title'])
                    ->line('Автор: '.$this->comment['author'])
                    ->line('Текст: '.$this->comment['content'])
                    ->action('Перейти к статье', route('show-article', ['id' => $this->comment['article_id']]))
                    ->line('Данное уведомление было сгенерировано автоматически, отвечать на него не нужно.');
    }

    /**
     * Получает представление уведомления в виде массива.
     *
     * @param mixed $notifiable уведомляемый объект.
     * @return array массив.
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
