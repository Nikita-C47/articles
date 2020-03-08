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
    protected $fillable = ['title', 'content', 'published'];

    protected $casts = [
        'published' => 'boolean'
    ];

    public function getPreviewAttribute()
    {
        return Str::limit($this->content, 350);
    }

    /**
     * Фильтр, выбирающий только одобренные события.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
