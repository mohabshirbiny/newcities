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

Route::post('register', 'Api\CustomerController@register');
Route::post('login', 'Api\CustomerController@login');
Route::post('verfiy', 'Api\CustomerController@customerVerify');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get("profile", "Api\CustomerController@getAuthenticatedUser");
    Route::post("update-profile", "Api\CustomerController@updateProfile");
    Route::post("change-password", "Api\CustomerController@changePassword");
    Route::get("logout", "Api\CustomerController@logout");
});