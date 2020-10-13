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

    Route::resource('events', 'Admin\EventController');
    Route::get('events/{id}/gallery', 'Admin\EventController@gallery')->name("events.gallery");
    Route::get('events/{id}/create-gallery', 'Admin\EventController@createGallery')->name("events.gallery.create");
    Route::post('events/{id}/gallery', 'Admin\EventController@storeGallery')->name("events.gallery.store");
    Route::get('events/{id}/gallery/{gallery}', 'Admin\EventController@deleteGallery')->name("events.gallery.delete");
    Route::resource('events-categories', 'Admin\EventCategoryController');
    Route::resource('events-sponsors', 'Admin\EventSponsorController');

    Route::post('add-event-sponsors/{id}', 'Admin\EventController@addSponsor')->name('events-add-sponsors');
    Route::get('remove-event-sponsors/{event_id}/{sponsor_id}', 'Admin\EventController@removeSponsor')->name('events-remove-sponsors');

    Route::post('add-event-organizers', 'Admin\EventController@addOrganizer')->name('events-add-organizers');
    Route::get('remove-event-organizers/{event_id}/{organizer_id}', 'Admin\EventController@removeOrganizer')->name('events-remove-organizers');

    Route::resource('events-organizers', 'Admin\EventOrganizerController');


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
    
    Route::get('sections', 'Admin\SectionDataController@getAll')->name('sections.index');
    Route::get('sections/{id}/gallery', 'Admin\SectionDataController@gallery')->name("sections.gallery");
    Route::get('sections/{id}/create-gallery', 'Admin\SectionDataController@createGallery')->name("sections.gallery.create");
    Route::post('sections/{id}/gallery', 'Admin\SectionDataController@storeGallery')->name("sections.gallery.store");
    Route::get('sections/{id}/gallery/{gallery}', 'Admin\SectionDataController@deleteGallery')->name("sections.gallery.delete");
    Route::get('sections/{id}', 'Admin\SectionDataController@edit')->name('sections.edit');
    Route::PUT('sections/{id}', 'Admin\SectionDataController@update')->name('sections.update');

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

    Route::get('property-items/grid', 'Admin\PropertyItemController@grid')->name("property-items.grid");
    Route::resource('property-items', 'Admin\PropertyItemController');

    Route::get('property-types/grid', 'Admin\PropertyTypeController@grid')->name("property-types.grid");
    Route::resource('property-types', 'Admin\PropertyTypeController');

    Route::get('facilities/grid', 'Admin\FacilityController@grid')->name("facilities.grid");
    Route::resource('facilities', 'Admin\FacilityController');

    Route::get('compounds/grid', 'Admin\CompoundController@grid')->name("compounds.grid");
    Route::get('compounds/{developer}/gallery', 'Admin\CompoundController@gallery')->name("compounds.gallery");
    Route::get('compounds/{developer}/create-gallery', 'Admin\CompoundController@createGallery')->name("compounds.gallery.create");
    Route::post('compounds/{developer}/gallery', 'Admin\CompoundController@storeGallery')->name("compounds.gallery.store");
    Route::get('compounds/{developer}/gallery/{gallery}', 'Admin\CompoundController@deleteGallery')->name("compounds.gallery.delete");

    Route::get('compounds/{compound}/attachments', 'Admin\CompoundController@attachments')->name("compounds.attachments");
    Route::get('compounds/{compound}/create-attachments', 'Admin\CompoundController@createAttachments')->name("compounds.attachments.create");
    Route::post('compounds/{compound}/attachments', 'Admin\CompoundController@storeAttachments')->name("compounds.attachments.store");
    Route::get('compounds/{compound}/attachments/{attachment}', 'Admin\CompoundController@deleteAttachments')->name("compounds.attachments.delete");

    Route::resource('compounds', 'Admin\CompoundController');

    Route::get('properties/grid', 'Admin\PropertyController@grid')->name("properties.grid");
    Route::get('properties/{property}/gallery', 'Admin\PropertyController@gallery')->name("properties.gallery");
    Route::get('properties/{property}/create-gallery', 'Admin\PropertyController@createGallery')->name("properties.gallery.create");
    Route::post('properties/{property}/gallery', 'Admin\PropertyController@storeGallery')->name("properties.gallery.store");
    Route::get('properties/{property}/gallery/{gallery}', 'Admin\PropertyController@deleteGallery')->name("properties.gallery.delete");
    
    Route::get('properties/{property}/attachments', 'Admin\PropertyController@attachments')->name("properties.attachments");
    Route::get('properties/{property}/create-attachments', 'Admin\PropertyController@createAttachments')->name("properties.attachments.create");
    Route::post('properties/{property}/attachments', 'Admin\PropertyController@storeAttachments')->name("properties.attachments.store");
    Route::get('properties/{property}/attachments/{attachment}', 'Admin\PropertyController@deleteAttachments')->name("properties.attachments.delete");
    
    Route::get('properties/{property}/items', 'Admin\PropertyController@items')->name("properties.items");
    Route::post('properties/{property}/items', 'Admin\PropertyController@storeItem')->name("properties.items.store");
    Route::get('properties/{property}/items/create', 'Admin\PropertyController@addItem')->name("properties.items.create");
    Route::get('properties/{property}/items/{item_id}', 'Admin\PropertyController@deleteItem')->name("properties.items.delete");    

    Route::resource('properties', 'Admin\PropertyController');
    
    Route::get('app-settings', 'Admin\AppSettingController@getAll')->name('settings.index');
    Route::post('app-settings', 'Admin\AppSettingController@store')->name('settings.store');

});
