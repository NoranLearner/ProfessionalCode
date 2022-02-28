<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

define('PAGINATION_COUNT',5);

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');


// Master Route
Route::get('master', function(){
    return view('layouts.master');
}) -> name('master');

// Portfolio Route
Route::get('portfolio', function(){
    return view('layouts.portfolio');
}) -> name('portfolio');

// About Route
Route::get('about', function(){
    return view('layouts.about');
}) ->name('about');

// Contact Route
Route::get('contact', function(){
    return view('layouts.contact');
}) ->name('contact');

// For Social Links

// Google login
Route::get('login/google','Auth\LoginController@redirectToGoogle') ->name('login-google');
Route::get('login/google/callback','Auth\LoginController@handleGoogleCallback');

// Facebook login
Route::get('login/facebook','Auth\LoginController@redirectToFacebook') ->name('login-facebook');
Route::get('login/facebook/callback','Auth\LoginController@handleFacebookCallback');

// Github login
Route::get('login/github','Auth\LoginController@redirectToGithub') ->name('login-github');
Route::get('login/github/callback','Auth\LoginController@handleGithubCallback');

//CrudController
// Route::get('fillable', 'CrudController@getOffers');
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::group(['prefix' => 'offers'],function(){
            Route::get('create', 'CrudController@create');
            Route::post('store', 'CrudController@store') ->name('offers-store');

            Route::get('edit/{offer_id}', 'CrudController@editOffer');
            Route::post('update/{offer_id}', 'CrudController@updateOffer') ->name('offers-update');

            Route::get('delete/{offer_id}', 'CrudController@deleteOffer') ->name('offers-delete');

            Route::get('all', 'CrudController@getAllOffers') ->name('offers-all');

            Route::get('get-all-inactive-offer', 'CrudController@getAllInactiveOffers');
        });
        // For Event & Listener
        Route::get('youtube', 'CrudController@getVideo') -> middleware('auth');
    });

################################## Begin Ajax Routes ##############################################

Route::group(['prefix' => 'ajaxoffers'], function(){
    Route::get('create','OfferController@create');
    Route::post('store', 'OfferController@store')->name('ajaxoffers-store');

    Route::get('all', 'OfferController@all') ->name('ajaxoffers-all');
    Route::post('delete', 'OfferController@delete') ->name('ajaxoffers-delete');

    Route::get('edit/{offer_id}', 'OfferController@edit') ->name('ajaxoffers-edit');
    Route::post('update', 'OfferController@update') ->name('ajaxoffers-update');
});

################################## Authentication #########################################

Route::group(['middleware' => 'CheckAge', 'namespace' => 'Auth'], function(){
    Route::get('adults','CustomAuthController@adult') -> name('adult');
});

################################### Guards ##################################################

Route::group(['namespace' => 'Auth'], function(){

    Route::get('site','CustomAuthController@site') -> middleware('auth:web') -> name('site');

    Route::get('admin','CustomAuthController@admin') -> middleware('auth:admin') -> name('admin');

    Route::get('admin/login','CustomAuthController@adminLogin') -> name('admin-login');

    Route::post('admin/login','CustomAuthController@checkAdminLogin') -> name('save-adminLogin');

});

#################################### Begin one to one relationship #################################################

Route::group(['namespace' => 'Relation'], function(){

    Route::get('has-one','RelationsController@hasOneRelation');

    Route::get('has-one-reverse','RelationsController@hasOneRelationReverse');

    Route::get('get-user-has-phone','RelationsController@getUserHasPhone');

    Route::get('get-user-not-has-phone','RelationsController@getUserNotHasPhone');

    Route::get('get-user-has-phone-with-condition','RelationsController@getUserWhereHasPhoneWithCondition');
});

#################################### Begin one to many relationship #################################################

Route::group(['namespace' => 'Relation'], function(){

    Route::get('hospital-has-many','RelationsController@getHospitalDoctors');

    Route::get('hospitals','RelationsController@hospitals') -> name('hospital.all');
    Route::get('doctors/{hospital_id}','RelationsController@doctors')-> name('hospital.doctors');

    Route::get('hospitals_has_doctors','RelationsController@hospitalsHasDoctor');

    Route::get('hospitals_has_doctors_male','RelationsController@hospitalsHasOnlyMaleDoctors');

    Route::get('hospitals_not_has_doctors','RelationsController@hospitals_not_has_doctors');

    Route::get('hospitals/{hospital_id}','RelationsController@deleteHospital') -> name('hospital.delete');

});

#################################### Begin many to many relationship #################################################

Route::group(['namespace' => 'Relation'], function(){

    Route::get('doctors-services','RelationsController@getDoctorServices');

    Route::get('service-doctors','RelationsController@getServiceDoctors');

    Route::get('doctors/services/{doctor_id}','RelationsController@getDoctorServicesById')-> name('doctors.services');

    Route::post('saveServices-to-doctor','RelationsController@saveServicesToDoctors')-> name('save.doctors.services');
});

######################### has one through & has many through ##########################

Route::group(['namespace' => 'Relation'], function(){

    Route::get('has-one-through','RelationsController@getPatientDoctor');

    Route::get('has-many-through','RelationsController@getCountryDoctor');

});

#######################  Begin Accessors & Mutators ###################

Route::get('accessors','Relation\RelationsController@getDoctors'); //get data


#######################  Begin Collection ###################

Route::get('collection','CollectTut@index');

Route::get('maincats','CollectTut@complex');

Route::get('main-cats','CollectTut@complexFilter');

Route::get('main-cat','CollectTut@complexTransform');
