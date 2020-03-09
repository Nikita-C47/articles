<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс, представляющий модель комментария к статье.
 * @package App\Models Модели приложения.
 *
 * @property int $id ID записи в БД.
 * @property int $article_id  ID статьи, к которой оставлен комментарий.
 * @property string $author Автор комментария.
 * @property string $content Содержимое комментария.
 * @property Carbon $created_at Дата создания.
 * @property Carbon $updated_at Дата обновления.
 *
 * @property Article $article Связная модель статьи, к которой оставлен комментарий.
 */
class Comment extends Model
{
    /** @var array $fillable заполняемые поля. */
    protected $fillable = ['article_id', 'author', 'content'];

    /**
     * Связь с моделью статьи.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }
}
