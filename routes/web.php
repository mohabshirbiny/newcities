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

Route::group(['prefix' => 'admin','resource' => 'Admin','middleware' => 'auth'], function () {

    Route::get('/', 'Admin\AdminController@index')->name('dashboard');

    Route::get('article-categories/grid', 'Admin\ArticleCategoryController@grid')->name("article-categories.grid");
    Route::resource('article-categories', 'Admin\ArticleCategoryController');

    Route::get('articles/grid', 'Admin\ArticleController@grid')->name("articles.grid");
    Route::resource('articles', 'Admin\ArticleController');

    Route::resource('city-districts', 'Admin\CityDistrictController');

    Route::resource('cities', 'Admin\CityController');

    Route::resource('tenders-categories', 'Admin\TenderCategoryController');
    Route::get('tenders/{id}/gallery', 'Admin\TenderController@gallery')->name("tenders.gallery");
    Route::get('tenders/{id}/create-gallery', 'Admin\TenderController@createGallery')->name("tenders.gallery.create");
    Route::post('tenders/{id}/gallery', 'Admin\TenderController@storeGallery')->name("tenders.gallery.store");
    Route::get('tenders/{id}/gallery/{gallery}', 'Admin\TenderController@deleteGallery')->name("tenders.gallery.delete");
    Route::resource('tenders', 'Admin\TenderController');
    
    Route::resource('offers', 'Admin\OfferController');
    Route::get('offers/{id}/gallery', 'Admin\OfferController@gallery')->name("offers.gallery");
    Route::get('offers/{id}/create-gallery', 'Admin\OfferController@createGallery')->name("offers.gallery.create");
    Route::post('offers/{id}/gallery', 'Admin\OfferController@storeGallery')->name("offers.gallery.store");
    Route::get('offers/{id}/gallery/{gallery}', 'Admin\OfferController@deleteGallery')->name("offers.gallery.delete");
    Route::resource('offers-categories', 'Admin\OfferCategoryController');


    Route::get('vendor-categories/grid', 'Admin\VendorCategoryController@grid')->name("vendor-categories.grid");
    Route::resource('vendor-categories', 'Admin\VendorCategoryController');

    Route::get('vendors/grid', 'Admin\VendorController@grid')->name("vendors.grid");
    Route::get('vendors/{vendor}/gallery', 'Admin\VendorController@gallery')->name("vendors.gallery");
    Route::get('vendors/{vendor}/create-gallery', 'Admin\VendorController@createGallery')->name("vendors.gallery.create");
    Route::post('vendors/{vendor}/gallery', 'Admin\VendorController@storeGallery')->name("vendors.gallery.store");
    Route::get('vendors/{vendor}/gallery/{gallery}', 'Admin\VendorController@deleteGallery')->name("vendors.gallery.delete");
    Route::resource('vendors', 'Admin\VendorController');

    Route::get('service-categories/grid', 'Admin\ServiceCategoryController@grid')->name("service-categories.grid");
    Route::resource('service-categories', 'Admin\ServiceCategoryController');

    Route::get('services/grid', 'Admin\ServiceController@grid')->name("services.grid");
    Route::get('services/{service}/gallery', 'Admin\ServiceController@gallery')->name("services.gallery");
    Route::get('services/{service}/create-gallery', 'Admin\ServiceController@createGallery')->name("services.gallery.create");
    Route::post('services/{service}/gallery', 'Admin\ServiceController@storeGallery')->name("services.gallery.store");
    Route::get('services/{service}/gallery/{gallery}', 'Admin\ServiceController@deleteGallery')->name("services.gallery.delete");
    Route::resource('services', 'Admin\ServiceController');

    Route::resource('jobs', 'Admin\JobController');

    Route::resource('jobs-categories', 'Admin\JobCategoryController');
});
