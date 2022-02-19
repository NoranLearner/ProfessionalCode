<?php

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
            Route::get('all', 'CrudController@getAllOffers');
        });
    });

