<?php

namespace App\Jobs;

use App\Models\Comment;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Класс, представляющий задание на проверку капчи.
 * @package App\Jobs Задания приложения.
 */
class CheckCaptcha implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array $commentData данные о добавляемом комментарии. */
    private $commentData;
    /** @var string $response ответ капчи. */
    private $response;

    /**
     * Иницализирует новый объект задания.
     *
     * @param array $commentData
     * @param string $response
     */
    public function __construct(array $commentData, string $response)
    {
        // Инициализируем данные
        $this->commentData = $commentData;
        $this->response = $response;
    }

    /**
     * Выполняет задание.
     *
     * @return void
     */
    public function handle()
    {
        // Заводим клиент Guzzle
        $client = new Client();
        // Делаем запрос
        $result = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('app.google_recaptcha.secret'),
                'response' => $this->response
            ]
        ]);
        // Если ответ не успешен, пишем в лог сообщение об ошибке
        if($result->getStatusCode() !== 200) {
            Log::error('Request for captcha checking failed for comment '.$this->commentData['content'].'"');
        }
        // Получаем контент ответа и декодируем его из JSON
        $content = json_decode($result->getBody()->getContents());
        // Если проверка успешная - добавляем комментарий
        if($content->success) {
            // Добавляем комментарий
            $comment = new Comment($this->commentData);
            $comment->save();
        } else {
            // Иначе - пишем в лог сообщение об ошибке
            Log::error('Captcha check failed for comment "'.$this->commentData['content'].'"');
        }
    }
}
