<?php

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



