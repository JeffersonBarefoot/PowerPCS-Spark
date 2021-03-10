<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',               'WelcomeController@show');

Route::get('/home',           'HomeController@show');

Route::get('/verifydestroy',  'PositionController@verifydestroy')->name('verifydestroy');
Route::get('/Tools',          'PositionController@Tools')->name('Tools');
Route::post('/uploadfile',    'PositionController@uploadfile')->name('uploadfile');
Route::resource('positions',  'PositionController');

Route::get('/dumpGridToCsv',  'ReportController@dumpGridToCsv')->name('dumpGridToCsv');
Route::resource('reports',    'ReportController');

Route::resource('incumbents', 'IncumbentController');
