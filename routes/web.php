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

// 登录
Route::get('/', 'Auth\LoginController@login')->name('login');
Route::post('/', 'Auth\LoginController@show');

// 前端 SPA 路由
Route::any('{all}', function() {
    return view('app');
})->where(['all' => '.*'])->middleware('auth');
