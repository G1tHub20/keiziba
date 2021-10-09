<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 書き換え必要
Route::resource('posts', 'App\Http\Controllers\PostController', ['only' => ['index','show', 'create', 'store']]);
Route::get('posts/edit/{id}', 'App\Http\Controllers\PostController@edit');
Route::post('posts/edit', 'App\Http\Controllers\PostController@update');
Route::post('posts/delete/{id}', 'App\Http\Controllers\PostController@destroy');