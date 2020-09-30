<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
//     });

Route::group(['middleware'=>'auth'],function () {

    Route::post('/projects','ProjectsController@store');//persist project
    Route::get('/projects/create/','ProjectsController@create');//create project route
    Route::get('/projects/{project}','ProjectsController@show');//showing project route
    Route::get('/projects','ProjectsController@index');//dashboard route
    Route::get('/home','HomeController@index')->name('home');

});


Auth::routes();


