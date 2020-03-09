<?php

use Illuminate\Database\Seeder;

/**
 * Класс, представляющий сидер данных приложения.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Заполняет базу данных приложения.
     *
     * @return void
     */
    public function run()
    {
        // Заполняем пользователей
        $this->call(UsersSeeder::class);
    }
}
