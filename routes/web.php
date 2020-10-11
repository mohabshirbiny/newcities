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

    Route::resource('tenders', 'Admin\TenderController');
    
    Route::resource('offers', 'Admin\OfferController');

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

    Route::get('developers/grid', 'Admin\DeveloperController@grid')->name("developers.grid");
    Route::get('developers/{developer}/gallery', 'Admin\DeveloperController@gallery')->name("developers.gallery");
    Route::get('developers/{developer}/create-gallery', 'Admin\DeveloperController@createGallery')->name("developers.gallery.create");
    Route::post('developers/{developer}/gallery', 'Admin\DeveloperController@storeGallery')->name("developers.gallery.store");
    Route::get('developers/{developer}/gallery/{gallery}', 'Admin\DeveloperController@deleteGallery')->name("developers.gallery.delete");
    Route::resource('developers', 'Admin\DeveloperController');

    Route::get('contractor-categories/grid', 'Admin\ContractorCategoryController@grid')->name("contractor-categories.grid");
    Route::resource('contractor-categories', 'Admin\ContractorCategoryController');

    Route::get('contractors/grid', 'Admin\ContractorController@grid')->name("contractors.grid");
    Route::get('contractors/{developer}/gallery', 'Admin\ContractorController@gallery')->name("contractors.gallery");
    Route::get('contractors/{developer}/create-gallery', 'Admin\ContractorController@createGallery')->name("contractors.gallery.create");
    Route::post('contractors/{developer}/gallery', 'Admin\ContractorController@storeGallery')->name("contractors.gallery.store");
    Route::get('contractors/{developer}/gallery/{gallery}', 'Admin\ContractorController@deleteGallery')->name("contractors.gallery.delete");
    Route::resource('contractors', 'Admin\ContractorController');
});
