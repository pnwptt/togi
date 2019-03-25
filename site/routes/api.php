<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/checklist/checkerrorcode', 'ChecklistController@checkerrorcode')->name('checkerrorcode');

Route::get('/workorder/findchecklist', 'WorkOrderController@findChecklist')->name('findChecklist');

Route::get('findErrorcode', function (Request $req) {
    return App\Models\Errorcode::where('c_code', $req['c_code'])->first();
})->name('findErrorcode');

Route::get('/test/wo', function () {
    return App\Models\WorkOrder::where('c_series', '330')->get();
});

Route::get('/test/cl', function () {
    return App\Models\Form::where('i_models_id', 5)->where('i_status', 1)->first();
});