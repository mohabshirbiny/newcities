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

Route::post('login', 'Api\CustomerController@login');
Route::post('verfiy', 'Api\CustomerController@customerVerify');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get("profile", "Api\CustomerController@getAuthenticatedUser");
    Route::post("update-profile", "Api\CustomerController@updateProfile");
    Route::post("change-password", "Api\CustomerController@changePassword");
    Route::get("logout", "Api\CustomerController@logout");
    Route::get("get-messages", "Api\CustomerController@getMessages");

    // cities
    Route::get("get-city-districts/{city_id}", "Api\CityDistrictController@getAll")->name('cities.districts.all');
    Route::get("get-city-district/{id}", "Api\CityDistrictController@getOne")->name('cities.districts.one');
    Route::get("get-cities", "Api\CityController@getAll")->name('cities.all');
    Route::get("get-city/{id}", "Api\CityController@getOne")->name('cities.one');

    // tenders
    Route::get("get-tender-categories", "Api\TenderCategoryController@getAll")->name('tenders.category.all');
    Route::get("get-tender-category/{id}", "Api\TenderCategoryController@getOne")->name('tenders.category.one');
    Route::get("get-tenders", "Api\TenderController@getAll")->name('tenders.all');
    Route::get("get-tender/{id}", "Api\TenderController@getOne")->name('tenders.one');

    // offers
    Route::get("get-offer-categories", "Api\OfferCategoryController@getAll")->name('offers.category.all');
    Route::get("get-offer-category/{id}", "Api\OfferCategoryController@getOne")->name('offers.category.one');
    Route::get("get-offers", "Api\OfferController@getAll")->name('offers.all');
    Route::get("get-offer/{id}", "Api\OfferController@getOne")->name('offers.one');
    
    // jobs
    Route::get("get-job-categories", "Api\JobCategoryController@getAll")->name('job.category.all');
    Route::get("get-job-category/{id}", "Api\JobCategoryController@getOne")->name('job.category.one');
    Route::get("get-jobs", "Api\JobController@getAll")->name('job.all');
    Route::get("get-job/{id}", "Api\JobController@getOne")->name('job.one');

    Route::get("get-article-categories", "Api\ArticleCategoryController@getAll");
    Route::get("get-article-category/{id}", "Api\ArticleCategoryController@getOne");

    Route::get("get-articles", "Api\ArticleController@getAll");
    Route::get("get-article/{id}", "Api\ArticleController@getOne");

    Route::get("get-event-categories", "Api\EventCategoryController@getAll");
    Route::get("get-event-category/{id}", "Api\EventCategoryController@getOne");

    Route::get("get-event-organizers", "Api\EventOrganizerController@getAll");
    Route::get("get-event-organizer/{id}", "Api\EventOrganizerController@getOne");

    Route::get("get-event-sponsors", "Api\EventSponsorController@getAll");
    Route::get("get-event-sponsor/{id}", "Api\EventSponsorController@getOne");

    Route::get("get-events", "Api\EventController@getAll");
    Route::get("get-event/{id}", "Api\EventController@getOne");
    Route::post("add-event-interest", "Api\EventController@addInterestedCustomer");
    Route::post("remove-event-interest", "Api\EventController@removeInterestedCustomer");

    Route::get("get-service-categories", "Api\ServiceCategoryController@getAll");
    Route::get("get-service-category/{id}", "Api\ServiceCategoryController@getOne");

    Route::get("get-services", "Api\ServiceController@getAll");
    Route::get("get-service/{id}", "Api\ServiceController@getOne");
    
    Route::get("get-vendor-categories", "Api\VendorCategoryController@getAll");
    Route::get("get-vendor-category/{id}", "Api\VendorCategoryController@getOne");

    Route::get("get-vendors", "Api\VendorController@getAll");
    Route::get("get-vendor/{id}", "Api\VendorController@getOne");

    Route::get("get-event-categories", "Api\EventCategoryController@getAll");
    Route::get("get-event-category/{id}", "Api\EventCategoryController@getOne");

    Route::get("get-developers", "Api\DeveloperController@getAll");
    Route::get("get-developer/{id}", "Api\DeveloperController@getOne");

    Route::get("get-contractor-categories", "Api\ContractorCategoryController@getAll");
    Route::get("get-contractor-category/{id}", "Api\ContractorCategoryController@getOne");

    Route::get("get-contractors", "Api\ContractorController@getAll");
    Route::get("get-contractor/{id}", "Api\ContractorController@getOne");
    
    Route::get("get-facilities", "Api\FacilityController@getAll");
    Route::get("get-facility/{id}", "Api\FacilityController@getOne");

    Route::get("get-property-items", "Api\PropertyItemController@getAll");
    Route::get("get-property-item/{id}", "Api\PropertyItemController@getOne");

    Route::get("get-property-types", "Api\PropertyTypeController@getAll");
    Route::get("get-property-type/{id}", "Api\PropertyTypeController@getOne");

    Route::get("get-properties", "Api\PropertyController@getAll");
    Route::get("get-property/{id}", "Api\PropertyController@getOne");
    Route::post("add-property-interest", "Api\PropertyController@addInterestedCustomer");
    Route::post("remove-property-interest", "Api\PropertyController@removeInterestedCustomer");

    Route::get("get-sections-data", "Api\SectionDataController@getAll");

    Route::get("get-compounds", "Api\CompoundController@getAll");
    Route::get("get-compound/{id}", "Api\CompoundController@getOne");
    
    Route::get("get-general-data", "Api\AppSettingController@getAll");
});
