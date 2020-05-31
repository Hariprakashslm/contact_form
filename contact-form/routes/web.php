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


Route::get('index', function () {
    return view('index');
});
Route::resource('location','LocationController');
Route::resource('ContactForm','ContactFormController');
Route::get('getLocationDataById','LocationController@getLocationDataById');
Route::get('AddLocation',function(){
	return view('location.create');
});
Route::post('locationUpdate','LocationController@locationUpdate');
Route::post('LocationDelete','LocationController@LocationDelete');

