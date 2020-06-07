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

Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::get('main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');
Route::get('main/forgetpassword', 'MainController@forgetpassword');
Route::get('insertEvents','EventController@insertEvents');
Route::get('deleteEvents','EventController@deleteEvents');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/scheduler/{id}', 'SchedularController@index');
Route::get('/appointment/{name}/{event_type}/{duration}/{id}', 'SchedularController@appointment');
Route::post('/insert_appointment', 'SchedularController@insert_appointment');
Route::post('/insert_appointment_user', 'SchedularController@insert_appointment_user');
Route::get('/appointment_user/{name}/{event_type}/{duration}/{selected_date}/{timeslot}/{last_inserted_id}/{user_id}', 'SchedularController@appointment_user');

Route::get('/appointment_confirmed/{name}/{event_type}/{selected_date}/{timeslot}/{message}/{user_id}','SchedularController@show_appointment_confirmed');

Route::get('/getDistictDate','SchedularController@getDistinctDate');
Route::get('/getEventByDate','SchedularController@getEventByDate');


