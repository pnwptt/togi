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

Route::get('/', 'DashboardController@index')->name('dashboard');

// Auth
Route::get('/login', 'LoginController@loginForm')->name('loginForm');
Route::post('/login', 'LoginController@login')->name('login');
Route::get('/logout', 'LoginController@logout')->name('logout');

// Models
Route::get('/models', 'ModelsController@index')->name('models');
Route::get('/models/create', 'ModelsController@createForm')->name('createModelsForm');
Route::post('/models/create', 'ModelsController@create')->name('createModels');
Route::get('/models/edit/{id}', 'ModelsController@editForm')->name('editModelsForm');
Route::post('/models/edit', 'ModelsController@edit')->name('editModels');
Route::get('/models/delete/{id}', 'ModelsController@delete')->name('deleteModels');

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
Route::get('/checklist/view/{id}', 'ChecklistController@viewForm')->name('viewChecklistForm');
// Route::get('/checklist/delete/{id}', 'ChecklistController@delete')->name('deleteChecklist');
Route::post('/checklist/status', 'ChecklistController@status')->name('statusChecklist');

// Record
Route::get('/record', 'RecordController@index')->name('record');
Route::get('/record/create', 'RecordController@createForm')->name('createRecordForm');
Route::post('/record/create', 'RecordController@create')->name('createRecord');
Route::get('/record/edit/{id}', 'RecordController@editForm')->name('editRecordForm');
Route::post('/record/edit', 'RecordController@edit')->name('editRecord');
Route::get('/record/delete/{id}', 'RecordController@delete')->name('deleteRecord');
