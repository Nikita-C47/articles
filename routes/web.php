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

Route::get('/home', 'HomeController@index')->name('home');

// Маршруты, доступные авторизованным пользователям
Route::middleware(['auth'])->group(function () {
    // Выход из приложения
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout-get');
});
