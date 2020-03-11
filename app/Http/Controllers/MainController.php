<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Jobs\CheckCaptcha;
use App\Models\Article;
use App\Models\Comment;
use GuzzleHttp\Client;
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
        // Получаем статью со счетчиком комментариев
        /** @var Article $article */
        $article = Article::published()->withCount('comments')->findOrFail($id);
        // Получаем отдельно комментарии
        $comments = $article->comments()->orderBy('created_at', 'desc')->paginate(10);
        // Возвращаем представление
        return view('main.show-article', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * Добавляет комментарий к статье.
     *
     * @param CommentFormRequest $request запрос на добавление комментария.
     * @return \Illuminate\Http\Response
     */
    public function addComment(CommentFormRequest $request)
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
            CheckCaptcha::dispatch(
                $request->except('g-recaptcha-response'), $request->get('g-recaptcha-response')
            );
            // Формируем уведомление
            $alert = [
                'type' => 'success',
                'text' => 'Ваш комментарий будет добавлен после проверки'
            ];
        }
        // Возвращаем редирект на указанную статью с уведомлением
        return redirect()->route('show-article', ['id' => $articleId])->with('alert', $alert);
    }
}
