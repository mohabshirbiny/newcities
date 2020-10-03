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

Auth::routes();


Route::get('/', 'HomeController@index')->name('dashboard');

Route::group(['prefix' => 'admin','resource' => 'Admin'], function () {

    Route::get('/', 'Admin\AdminController@index')->name('dashboard');

    Route::get('article-categories/grid', 'Admin\ArticleCategoryController@grid')->name("article-categories.grid");
    Route::resource('article-categories', 'Admin\ArticleCategoryController');

    Route::get('articles/grid', 'Admin\ArticleController@grid')->name("articles.grid");
    Route::resource('articles', 'Admin\ArticleController');

    Route::get('city-categories/grid', 'Admin\CityCategoryController@grid')->name("city-categories.grid");
    Route::resource('city-categories', 'Admin\CityCategoryController');

    Route::get('cities/grid', 'Admin\CityController@grid')->name("cities.grid");
    Route::resource('cities', 'Admin\CityController');
});
