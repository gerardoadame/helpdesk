<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'App\Http\Controllers\LogController@login');
    Route::post('signup', 'App\Http\Controllers\LogController@signUp');

        

    

    // ruta de prueba 1
    Route::get('test1', function () {
        return response()->json([
            'status'=>200,
            'messange' =>"ruta de prueba fuera del middleware"
        ]);
    });

    Route::group([
    'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'App\Http\Controllers\LogController@logout');
        Route::post('createTicket','App\Http\Controllers\TicketController@create');

       

        // esta ruta regresa una lista de todos los usuarios
        Route::get('user', 'App\Http\Controllers\UserController@user');
        // ruta de prueba para informacion del usuario
        Route::get('user/detail', 'App\Http\Controllers\UserController@detail');
        // ruta de prueba 2
        Route::get('test2', 'App\Http\Controllers\LogController@user');

        // esta ruta es para editar datos de un usuario
        Route::put('user/edit/{id}', 'App\Http\Controllers\UserController@edit');

    });
});
