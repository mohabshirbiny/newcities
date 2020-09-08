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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('article-categories/grid', 'Admin\ArticleCategoryController@grid')->name("article-categories.grid");
    Route::resource('article-categories', 'Admin\ArticleCategoryController');

    Route::get('articles/grid', 'Admin\ArticleController@grid')->name("articles.grid");
    Route::resource('articles', 'Admin\ArticleController');
});
