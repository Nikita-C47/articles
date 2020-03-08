<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Класс, представляющий seeder пользователей.
 */
class UsersSeeder extends Seeder
{
    /**
     * Запускает заполнение БД.
     *
     * @return void
     */
    public function run()
    {
        // Список пользователей, которых необходимо добавить
        $users = [
            [
                'name' => 'Администратор',
                'email' => 'admin@example.com',
                'password' => "qwerty123",
            ]
        ];
        // Перебираем список и добавляем пользователей
        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'email_verified_at' => now()
                ]
            );
        }
    }
}
