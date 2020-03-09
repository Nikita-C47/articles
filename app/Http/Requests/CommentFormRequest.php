<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Класс, представляющий запрос на добавление комментария.
 * @package App\Http\Requests Запросы приложения.
 */
class CommentFormRequest extends FormRequest
{
    /**
     * Определяет, может ли пользователь выполнять этот запрос.
     *
     * @return bool
     */
    public function authorize()
    {
        // Выполнять запрос может любой пользователь
        return true;
    }

    /**
     * Возвращает правила валидации.
     *
     * @return array массив с правилами валидации.
     */
    public function rules()
    {
        // Общие правила валидации
        $rules = [
            // ID статьи, к которой добавляется комментарий
            'article_id' => 'required|exists:articles,id',
            // Текст статьи
            'content' => 'required'
        ];
        // Если пользователь не авторизован
        if(!Auth::check()) {
            // Нужно заполнить автора
            $rules['author'] = 'required';
            // И ответ капчи
            $rules['g-recaptcha-response'] = 'required';
        }
        // Возвращаем правила
        return $rules;
    }
}
