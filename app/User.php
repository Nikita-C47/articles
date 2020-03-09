<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Класс, представляющий модель пользователя приложения.
 * @package App Основное пространство имен приложения.
 *
 * @property int $id ID пользователя в БД.
 * @property string $name Имя пользователя.
 * @property string $email Email пользователя.
 * @property Carbon $email_verified_at Дата подтверждения email.
 * @property Carbon $created_at Дата создания.
 * @property Carbon $updated_at Дата обновления.
 */
class User extends Authenticatable
{
    use Notifiable;

    /** @var array $fillable заполняемые поля. */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at'
    ];

    /** @var array $hidden атрибуты, которые скрыты из массивов. */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /** @var array $casts сопоставляемые атрибуты. */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
