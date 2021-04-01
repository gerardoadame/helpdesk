<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LogController, TicketController, UserController};

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
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('logout', [LogController::class, 'logout']);

    Route::prefix('users')->group(function () {
        // Lista de usuarios
        Route::get('', [LogController::class, 'user']);
        // Info. personal de usuario
        Route::get('detail', [UserController::class, 'detail']); // /users/{id}
        Route::put('edit/{id}', [UserController::class, 'edit']);
    });

    Route::prefix('tickets')->group(function () {
        Route::post('create', [TicketController::class, 'create']);
    });

    //Route::post('createTicket', 'App\Http\Controllers\EmpleadoController@create');
});
