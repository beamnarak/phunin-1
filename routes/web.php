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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/reports/', 'ReportController@index')->name('reports.index');
Route::get('/reports/underminimum', 'ReportController@underminimum')->name('reports.underminimum');
Route::get(
    '/reports/stockin_each_shop/',
    ['as' => 'reports.stockin_each_shop', 'uses' => 'ReportController@stockin_each_shop']);
Route::get(
    '/reports/stockout_each_machine/',
    ['as' => 'reports.stockout_each_machine', 'uses' => 'ReportController@stockout_each_machine']);
Route::get(
    '/reports/conclusion_each_month/',
    ['as' => 'reports.conclusion_each_month', 'uses' => 'ReportController@conclusion_each_month']);
Route::get(
    '/reports/conclusion/',
    ['as' => 'reports.conclusion', 'uses' => 'ReportController@conclusion']);
Route::get(
    '/reports/each_category/',
    ['as' => 'reports.each_category', 'uses' => 'ReportController@each_category']);

Route::get('/reports/search/', 'ReportController@search')->name('reports.search');
Route::get('/stock_ins/fix_date/', 'StockInController@fix_date')->name('stock_ins.fix_date');
Route::get('/stock_ins/delete_x/', 'StockInController@delete_x')->name('stock_ins.delete_x');
Route::resource('units','UnitController');
Route::resource('repairments','RepairmentController');
Route::resource('categories','CategoryController');
Route::resource('positions','PositionController');
Route::resource('spare_parts','SparePartController');
Route::resource('shops','ShopController');
Route::resource('departments','DepartmentController');
Route::resource('machines','MachineController');
Route::resource('employees','EmployeeController');
Route::resource('stock_ins','StockInController');
Route::resource('stock_outs','StockOutController');
Route::resource('machine_categories','MachineCategoryController');
Route::post('/spare_parts/search/', 'SparePartController@search')->name('spare_parts.search');

Route::post('/stock_ins/search/', 'StockInController@search')->name('stock_ins.search');
Route::post('/stock_ins/searchByPID/', 'StockInController@searchByPID')->name('stock_ins.searchByPID');

Route::post('/stock_outs/search/', 'StockOutController@search')->name('stock_outs.search');
Route::post('/stock_outs/searchByRID/', 'StockOutController@searchByRID')->name('stock_outs.searchByRID');

Route::post('/categories/search/', 'CategoryController@search')->name('categories.search');

// handle AJAX
Route::get('repairments/autocomplete', 'RepairmentController@autocomplete');
