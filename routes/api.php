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

Route::resource('notes', 'NoteController');
Route::resource('tags', 'TagController');
Route::resource('categories', 'CategoryController');

Route::get('trash', 'NoteController@trash');
Route::get('important', 'NoteController@important');
Route::get('change_important/{id}', 'NoteController@changeImportant');