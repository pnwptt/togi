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

// Checklist
Route::get('/checklist', 'ChecklistController@index')->name('checklist');
Route::get('/checklist/create', 'ChecklistController@createForm')->name('createChecklistForm');
Route::post('/checklist/create', 'ChecklistController@create')->name('createChecklist');
// Route::get('/checklist/list/{id}', 'ChecklistController@list')->name('checklistList');

