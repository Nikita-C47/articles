<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Класс, представляющий миграцию создания таблицы статей.
 */
class AddArticlesTable extends Migration
{
    /**
     * Запускает миграцию.
     *
     * @return void
     */
    public function up()
    {
        // Таблица со статьями
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Откатывает миграцию.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
