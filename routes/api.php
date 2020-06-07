<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('insert_event','api\EventController@create');
Route::get('delete_event','api\EventController@delete');
Route::post('edit_event','api\EventController@update');
Route::get('getEvent','api\EventController@index');
Route::post('articles', 'ArticleController@store');
