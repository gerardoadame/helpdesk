<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ LogController, TicketController, UserController };

/*
|------------------------------------------------------------------------------|
| API Routes                                                                   |
|------------------------------------------------------------------------------|
|
| Here is where you can register API routes. These routes are loaded by the
| RouteServiceProvider within a group which is assigned the "api" middleware
| group.
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [LogController::class, 'login']);
    //Route::post('signup', [LogController::class, 'signUp']); No contemplado
    Route::get('logout', [LogController::class, 'logout']);
});

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'App\Http\Controllers\LogController@logout');

        Route::get('user', 'App\Http\Controllers\LogController@user');
        Route::post('createTicket','App\Http\Controllers\EmpleadoController@create');
    });

Route::middleware(['auth:api'])->group(function () {


    Route::prefix('users')->group(function () {
        // Lista de usuarios
        Route::get('', [LogController::class, 'user']);
        // Info. personal de usuario
        Route::get('detail', [UserController::class, 'detail']); // /users/{id}
        Route::put('edit/{id}', [UserController::class, 'edit']);
    });


        // esta ruta es para editar datos de un usuario
        Route::put('user/edit/{id}', 'App\Http\Controllers\UserController@edit');


    Route::prefix('tickets')->group(function () {
        Route::post('create', [TicketController::class, 'create']);

    });
});
