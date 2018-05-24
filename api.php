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

Route::post('/login', 'AppController@login');
Route::post('/register', 'AppController@register');

Route::middleware('auth:api')->group(function () {
    Route::post('/servers', 'AppController@servers');
    Route::post('/servers/{server}', 'AppController@server');
    Route::post('/data', 'MoniController@data');
});