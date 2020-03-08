<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false, 'verify' => false]);

// Маршруты, доступные авторизованным пользователям
Route::middleware(['auth'])->group(function () {
    // Выход из приложения
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout-get');

    // Статьи
    Route::get('/admin/articles', 'ArticlesController@index')->name('articles');
    Route::get('/admin/articles/create', 'ArticlesController@create')->name('create-article');
    Route::post('/admin/articles/create', 'ArticlesController@store');
    Route::get('/admin/articles/{id?}', 'ArticlesController@show')->name('view-article');
    Route::get('/admin/articles/{id?}/edit', 'ArticlesController@edit')->name('edit-article');
    Route::post('/admin/articles/{id?}/edit', 'ArticlesController@update');
    Route::post('/admin/articles/{id?}/delete', 'ArticlesController@destroy')->name('delete-article');
});

Route::get('/articles/{id?}', 'MainController@showArticle')->name('show-article');

Route::get('/', 'MainController@index')->name('home');
