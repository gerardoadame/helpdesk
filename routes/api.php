<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LogController, TicketController, UserController};
use GuzzleHttp\Psr7\Request;

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
     //No contemplado
    Route::post('signup', [LogController::class, 'signUp']);
    
});

// ruta de prueba 1
Route::post('test1', 'App\Http\Controllers\UserController@test2')->name('test1');

Route::middleware(['auth:api'])->group(function () {
    Route::get('auth/logout', [LogController::class, 'logout']);

    Route::prefix('users')->group(function () {
        // Lista de usuarios
        Route::get('', [UserController::class, 'user']);
        // Info. personal de usuario
        Route::get('detail', [UserController::class, 'detail']);
        // Route::put('edit/{id}', [UserController::class, 'edit']);
        Route::put('edit', [UserController::class, 'edit']);
    });

    Route::prefix('tickets')->group(function () {
        Route::post('create', [TicketController::class, 'create']);
        Route::get('view/{id}', [TicketController::class, 'viewOne']);
        // Route::put('edit/{id}', [TicketController::class, 'edit']);
        Route::put('edit/{id}', [TicketController::class, 'edit']);
    });

    //Route::post('createTicket', 'App\Http\Controllers\EmpleadoController@create');

    // ruta de prueba 2
    Route::get('test2', [UserController::class, 'test2'])->name('test2');
});
