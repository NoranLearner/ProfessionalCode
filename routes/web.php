<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

################################## Authentication & Guards #########################################

Route::group(['middleware' => 'CheckAge', 'namespace' => 'Auth'], function(){
    Route::get('adults','CustomAuthController@adult') -> name('adult');
});
