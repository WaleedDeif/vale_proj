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
Route::get('/projects', 'ProjectController@index')->name('projects.index')->middleware('auth');
Route::get('/projects/{project}', 'ProjectController@show')->name('projects.show')->middleware('auth');
Route::get('/tasks/create', 'TaskController@create')->name('tasks.create')->middleware('auth');
Route::post('/tasks', 'TaskController@store')->name('tasks.store')->middleware('auth');
