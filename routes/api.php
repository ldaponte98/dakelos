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

Route::group(['prefix' => 'app'], function(){
    Route::get('validar-app/{app_name}', 'AppController@validar_app_name');
    Route::get('productos/{app_name}', 'AppController@productos');
});

Route::get('tercero/listar', 'TerceroController@listar');
