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
Route::get('/series/edit/{id}', 'SeriesController@editForm')->name('editSeriesForm');
Route::post('/series/edit', 'SeriesController@edit')->name('editSeries');
Route::get('/series/delete/{id}', 'SeriesController@delete')->name('deleteSeries');

// Errorcode
Route::get('/errorcode', 'ErrorcodeController@index')->name('errorcode');
Route::get('/errorcode/create', 'ErrorcodeController@createForm')->name('createErrorcodeForm');
Route::post('/errorcode/create', 'ErrorcodeController@create')->name('createErrorcode');
Route::get('/errorcode/edit/{id}', 'ErrorcodeController@editForm')->name('editErrorcodeForm');
Route::post('/errorcode/edit', 'ErrorcodeController@edit')->name('editErrorcode');
Route::get('/errorcode/delete/{id}', 'ErrorcodeController@delete')->name('deleteErrorcode');

// ErrorcodeType
Route::get('/errorcodetype', 'ErrorcodeTypeController@index')->name('errorcodetype');
Route::get('/errorcodetype/create', 'ErrorcodeTypeController@createForm')->name('createErrorcodetypeForm');
Route::post('/errorcodetype/create', 'ErrorcodeTypeController@create')->name('createErrorcodetype');
Route::get('/errorcodetype/edit/{id}', 'ErrorcodeTypeController@editForm')->name('editErrorcodeTypeForm');
Route::post('/errorcodetype/edit', 'ErrorcodeTypeController@edit')->name('editErrorcodeType');
Route::get('/errorcodetype/delete/{id}', 'ErrorcodeTypeController@delete')->name('deleteErrorcodetype');

// Checklist
Route::get('/checklist', 'ChecklistController@index')->name('checklist');
Route::get('/checklist/create', 'ChecklistController@createForm')->name('createChecklistForm');
Route::post('/checklist/create', 'ChecklistController@create')->name('createChecklist');
Route::get('/checklist/edit/{id}', 'ChecklistController@editForm')->name('editChecklistForm');
Route::post('/checklist/edit', 'ChecklistController@edit')->name('editChecklist');
Route::get('/checklist/checkerrorcode', 'ChecklistController@checkerrorcode')->name('checkerrorcode');
Route::get('/checklist/delete/{id}', 'ChecklistController@delete')->name('deleteChecklist');

// Record
Route::get('/record', 'RecordController@index')->name('record');
Route::get('/record/create', 'RecordController@createForm')->name('createRecordForm');
Route::post('/record/create', 'RecordController@create')->name('createRecord');
Route::get('/record/edit/{id}', 'RecordController@editForm')->name('editRecordForm');
Route::post('/record/edit', 'RecordController@edit')->name('editRecord');
Route::get('/record/delete/{id}', 'RecordController@delete')->name('deleteRecord');
