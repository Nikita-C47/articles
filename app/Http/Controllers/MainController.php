<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Класс, представляющий контроллер публичной части приложения.
 * @package App\Http\Controllers Контроллеры приложения.
 */
class MainController extends Controller
{
    /**
     * Отображает список статей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Получаем разбитый по страницам список
        $articles = Article::published()
            ->withCount('comments')
            ->orderBy('id', 'desc')
            ->paginate(5);
        // Возвращаем представление
        return view('main.index', [
            'articles' => $articles
        ]);
    }

    /**
     * Отображает статью.
     *
     * @param int $id ID статьи.
     * @return \Illuminate\Http\Response
     */
    public function showArticle($id)
    {
        /** @var Article $article */
        $article = Article::published()->withCount('comments')->findOrFail($id);
        $comments = $article->comments()->orderBy('created_at', 'desc')->paginate(10);
        return view('main.show-article', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * Добавляет комментарий к статье.
     *
     * @param CommentRequest $request запрос на добавление комментария.
     * @return \Illuminate\Http\Response
     */
    public function addComment(CommentRequest $request)
    {
        // Получаем ID статьи
        $articleId = $request->get('article_id');

        // Если пользователь авторизован - просто сохраняем статью
        if(Auth::check()) {
            /** @var \App\User $user */
            $user = Auth::user();
            // Добавляем новый комментарий
            $comment = new Comment([
                'article_id' => $articleId,
                'author' => $user->name,
                'content' => $request->get('content')
            ]);
            $comment->save();
            // Генерируем алерт
            $alert = [
                'type' => 'success',
                'text' => 'Ваш комментарий успешно добавлен'
            ];
        } else {
            // Если пользователь не авторизован - нужно проверить капчу
            if($this->verifyCaptcha($request->get('g-recaptcha-response'))) {
                // Добавляем новый комментарий
                $comment = new Comment([
                    'article_id' => $articleId,
                    'author' => $request->get('author'),
                    'content' => $request->get('content')
                ]);
                $comment->save();
                // Генерируем алерт
                $alert = [
                    'type' => 'success',
                    'text' => 'Ваш комментарий успешно добавлен'
                ];
            } else {
                // Иначе указываем что есть проблемы
                $alert = [
                    'type' => 'danger',
                    'text' => 'Подтвердите, что вы не робот!'
                ];
            }
        }
        // Возвращаем редирект на указанную статью с уведомлением
        return redirect()->route('show-article', ['id' => $articleId])->with('alert', $alert);
    }

    /**
     * Проверяет ответ Google captcha.
     *
     * @param string $response ответ google captcha.
     * @return bool флаг успешности проверки.
     */
    private function verifyCaptcha(string $response)
    {
        // Заводим клиент Guzzle
        $client = new Client();
        // Делаем запрос
        $result = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('app.google_recaptcha.secret'),
                'response' => $response
            ]
        ]);
        // Если ответ не успешен, возвращаем ложь
        if($result->getStatusCode() !== 200) {
            return false;
        }
        // Получаем контент ответа и декодируем его из JSON
        $content = json_decode($result->getBody()->getContents());
        // Возвращаем статус проверки
        return $content->success;
    }
}
