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

Route::get('trash', 'NoteController@trash');           //临时删除
Route::get('important', 'NoteController@important');
Route::get('change_important/{id}', 'NoteController@changeImportant');
Route::get('get_count', 'NoteController@getCount');    //获取删除的和收藏的note数量
Route::put('untrash/{id}', 'NoteController@untrash');  //恢复
Route::delete('trash/{id}', 'NoteController@trashForever'); //永久删除