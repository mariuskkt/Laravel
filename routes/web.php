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

Route::get('/test/{id}', function ($id) {
    return $id;
});

Auth::routes();

Route::get('/home', 'Admin\HomeController@index')->name('home');
Route::get('/info/{id}', 'Admin\InfoController@index')->name('info');
Route::view('/test-list', 'list', ['list' => ['vienas', 'du', 'trys', 'keturi', 'penki']])->name('test');
Route::get('/dashboard', 'DashController@index')->name('dash');
Route::resource('/achievements', 'AchievementController');
Route::resource('/bikes', 'BikesController');
Route::resource('/userbikes', 'UserBikesController');
