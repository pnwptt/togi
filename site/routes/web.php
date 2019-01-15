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

Route::get('/', function () {
    return view('home');
})->name('home');

// Series
Route::get('/series', 'SeriesController@index')->name('series');
Route::get('/series/create', 'SeriesController@createForm')->name('createSeriesForm');
Route::post('/series/create', 'SeriesController@create')->name('createSeries');
Route::get('/series/delete/{id}', 'SeriesController@delete')->name('deleteSeries');

// Errorcode
Route::get('/errorcode', 'ErrorcodeController@index')->name('errorcode');
Route::get('/errorcode/create', 'ErrorcodeController@createForm')->name('createErrorcodeForm');
Route::post('/errorcode/create', 'ErrorcodeController@create')->name('createErrorcode');
Route::get('/errorcode/delete/{id}', 'ErrorcodeController@delete')->name('deleteErrorcode');

// ErrorcodeType
Route::get('/errorcodetype', 'ErrorcodeTypeController@index')->name('errorcodetype');
Route::get('/errorcodetype/create', 'ErrorcodeTypeController@createForm')->name('createErrorcodetypeForm');
Route::post('/errorcodetype/create', 'ErrorcodeTypeController@create')->name('createErrorcodetype');
Route::get('/errorcodetype/delete/{id}', 'ErrorcodeTypeController@delete')->name('deleteErrorcodetype');

// Checklist
Route::get('/checklist', 'ChecklistController@index')->name('checklist');
Route::get('/checklist/create', 'ChecklistController@createForm')->name('createChecklistForm');
Route::post('/checklist/create', 'ChecklistController@create')->name('createChecklist');
// Route::get('/checklist/list/{id}', 'ChecklistController@list')->name('checklistList');

