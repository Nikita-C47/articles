<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $comment;

    /**
     * Create a new notification instance.
     *
     * @param array $comment
     */
    public function __construct(array $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // TODO: Русификация сообщений валидации
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
