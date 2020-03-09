<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Класс, представляющий модель статьи.
 * @package App\Models Модели приложения.
 *
 * @property int $id ID записи в БД.
 * @property string $title Заголовок статьи.
 * @property string $content Содержимое статьи.
 * @property string $preview Краткое содержание статьи.
 * @property bool $published Статус публикации.
 * @property Carbon $created_at Дата создания.
 * @property Carbon $updated_at Дата обновления.
 *
 * @property Collection $comments Связная модель списка комментариев к статье.
 *
 * @method static Builder published() Показывает только опубликованные статьи.
 */
class Article extends Model
{
    /** @var array $fillable заполняемые поля. */
    protected $fillable = ['title', 'content', 'published'];
    /** @var array $casts сопоставляемые атрибуты. */
    protected $casts = [
        'published' => 'boolean'
    ];

    /**
     * Возвращает атрибут с предпросмотром статьи.
     *
     * @return string Предпросмотр статьи.
     */
    public function getPreviewAttribute()
    {
        // Выбираем первые 350 символов текста статьи
        return Str::limit($this->content, 350);
    }

    /**
     * Фильтр, выбирающий только одобренные события.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query входящий объект построителя запросов.
     * @return \Illuminate\Database\Eloquent\Builder измененный объект построителя запросов.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Связь с таблицей комментариев.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
