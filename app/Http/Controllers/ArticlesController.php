<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;
use Illuminate\Http\Request;

/**
 * Класс, представляющий контроллер для работы со статьями.
 * @package App\Http\Controllers Контроллеры приложения.
 */
class ArticlesController extends Controller
{
    /**
     * Отображает список статей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Получаем разбитый по страницам список
        $articles = Article::orderBy('id', 'desc')->paginate(10);
        // Возвращаем представление
        return view('articles.index', [
            'articles' => $articles
        ]);
    }

    /**
     * Отображает форму добавления статьи.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Сохраняет новую статью.
     *
     * @param ArticleFormRequest $request запрос на добавление статьи.
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleFormRequest $request)
    {
        // Создаем статью
        $article = new Article([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'published' => $request->has('published')
        ]);
        $article->save();
        // Перенаправляем на список статей с уведомлением
        return redirect()->route('articles')->with('alert', [
            'type' => 'success',
            'text' => 'Новая статья успешно добавлена'
        ]);
    }

    /**
     * Отображает детальную страницу статьи.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.view', ['article' => $article]);
    }

    /**
     * Отображает форму редактирования статьи.
     *
     * @param int $id ID записи в БД.
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Обновляет запись в БД.
     *
     * @param ArticleFormRequest $request Запрос на обновление статьи.
     * @param int $id ID статьи.
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleFormRequest $request, $id)
    {
        // Получаем статью
        /** @var Article $article */
        $article = Article::findOrFail($id);
        $article->fill([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'published' => $request->has('published')
        ]);
        // Сохраняем ее
        $article->save();
        // Перенаправляем на список статей с уведомлением
        return redirect()->route('articles')->with('alert', [
            'type' => 'success',
            'text' => 'Статья #'.$article->id.' успешно обновлена'
        ]);
    }

    /**
     * Удаляет статью из БД.
     *
     * @param int $id ID статьи в БД.
     * @return \Illuminate\Http\Response
     * @throws \Exception Исключение при неудачном удалении.
     */
    public function destroy($id)
    {
        // Получаем статью
        /** @var Article $article */
        $article = Article::findOrFail($id);
        $article->delete();
        // Перенаправляем на список статей с уведомлением
        return redirect()->route('articles')->with('alert', [
            'type' => 'success',
            'text' => 'Статья #'.$article->id.' успешно удалена'
        ]);
    }
}
