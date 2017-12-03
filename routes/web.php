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
Route::resource('units','UnitController');
Route::resource('categories','CategoryController');
Route::resource('positions','PositionController');
Route::resource('spare_parts','SparePartController');
Route::resource('shops','ShopController');
Route::resource('departments','DepartmentController');
Route::resource('machines','MachineController');
Route::resource('employees','EmployeeController');
