<?php

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

Route::post('register', 'Api\CustomerController@register');
Route::post('login', 'Api\CustomerController@login');
Route::post('verfiy', 'Api\CustomerController@customerVerify');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get("profile", "Api\CustomerController@getAuthenticatedUser");
    Route::post("update-profile", "Api\CustomerController@updateProfile");
    Route::post("change-password", "Api\CustomerController@changePassword");
    Route::get("logout", "Api\CustomerController@logout");
});

Route::get("get-article-categories", "Api\ArticleCategoryController@getAll");
Route::get("get-article-category/{id}", "Api\ArticleController@getOne");

Route::get("get-articles", "Api\ArticleController@getAll");
Route::get("get-article/{id}", "Api\ArticleController@getOne");

Route::get("get-vendor-categories", "Api\VendorCategoryController@getAll");
Route::get("get-vendor-category/{id}", "Api\VendorCategoryController@getOne");

Route::get("get-event-categories", "Api\EventCategoryController@getAll");
Route::get("get-event-category/{id}", "Api\EventCategoryController@getOne");

Route::get("get-event-organizers", "Api\EventOrganizerController@getAll");
Route::get("get-event-organizer/{id}", "Api\EventOrganizerController@getOne");

Route::get("get-event-sponsors", "Api\EventSponsorController@getAll");
Route::get("get-event-sponsor/{id}", "Api\EventSponsorController@getOne");

Route::get("get-events", "Api\EventController@getAll");
Route::get("get-events/{id}", "Api\EventController@getOne");

Route::get("get-service-categories", "Api\ServiceCategoryController@getAll");
Route::get("get-service-category/{id}", "Api\ServiceCategoryController@getOne");

Route::get("get-event-categories", "Api\EventCategoryController@getAll");
Route::get("get-event-category/{id}", "Api\EventCategoryController@getOne");