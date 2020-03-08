<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

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
        $articles = Article::published()->orderBy('id', 'desc')->paginate(5);
        // Возвращаем представление
        return view('main.index', [
            'articles' => $articles
        ]);
    }

    public function showArticle($id)
    {
        $article = Article::published()->findOrFail($id);
        return view('main.show-article', ['article' => $article]);
    }
}
