<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'Api\CustomerController@login');
Route::post('verfiy', 'Api\CustomerController@customerVerify');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get("profile", "Api\CustomerController@getAuthenticatedUser");
    Route::post("update-profile", "Api\CustomerController@updateProfile");
    Route::post("change-password", "Api\CustomerController@changePassword");
    Route::get("logout", "Api\CustomerController@logout");

    // tenders
    Route::get("get-tender-categories", "Api\TenderCategoryController@getAll")->name('tenders.category.all');
    Route::get("get-tender-category/{id}", "Api\TenderCategoryController@getOne")->name('tenders.category.one');
    Route::get("get-tenders", "Api\TenderController@getAll")->name('tenders.all');
    Route::get("get-tender/{id}", "Api\TenderController@getOne")->name('tenders.one');

});

Route::get("get-article-categories", "Api\ArticleCategoryController@getAll");
Route::get("get-article-category/{id}", "Api\ArticleController@getOne");

Route::get("get-articles", "Api\ArticleController@getAll");
Route::get("get-article/{id}", "Api\ArticleController@getOne");