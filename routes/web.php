<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware("auth")
->namespace("Admin") // -> folder where controller are located
->name("admin.") // -> before every route I have this prefix
->prefix("admin") // -> before every URI this prefix
->group(function() {
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/test', 'HomeController@test')->name('test');

    Route::resource('posts', 'PostController');
});