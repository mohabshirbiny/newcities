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

Route::post('register', 'Api\PlayerController@register');
Route::post('login', 'Api\PlayerController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get("profile", "Api\PlayerController@getAuthenticatedUser");
    Route::post("update-profile", "Api\PlayerController@updateProfile");
    Route::post("change-password", "Api\PlayerController@changePassword");
    Route::get("logout", "Api\PlayerController@logout");
});