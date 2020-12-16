<?php

// デフォルトのコメント部分は省略
//追加
// Route::get('/', function () {
//     return view('welcome');
// });
//
Route::get('/', 'TasksController@index');

Route::resource('tasks', 'TasksController');
//認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('tasklist', 'TasksController', ['only' => ['store', 'destroy']]);
});