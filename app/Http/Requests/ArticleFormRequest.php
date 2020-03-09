<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Класс, представляющий запрос на добавление/обновление статьи.
 * @package App\Http\Requests Запросы приложения.
 */
class ArticleFormRequest extends FormRequest
{
    /**
     * Определяет, может ли пользователь выполнять этот запрос.
     *
     * @return bool
     */
    public function authorize()
    {
        // Выполнять запрос может только авторизованный пользователь
        return Auth::check();
    }

    /**
     * Возвращает правила валидации.
     *
     * @return array массив с правилами валидации.
     */
    public function rules()
    {
        return [
            // Заголовок статьи
            'title' => 'required',
            // Текст статьи
            'content' => 'required'
        ];
    }
}
