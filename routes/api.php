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
    Route::post('login', [LogController::class, 'login'])->middleware('cors');
    //No contemplado
    //Route::post('signup', [LogController::class, 'signUp']);
});

Route::middleware(['auth:api', 'cors'])->group(function () {

    Route::get('auth/logout', [LogController::class, 'logout']);

    Route::prefix('users')->group(function () {
        // Lista de usuarios
        Route::get('', [UserController::class, 'user']);
        // Info. personal de usuario
        Route::get('detail', [UserController::class, 'detail']);
        // editar informacion del usuario
        Route::get('edit', [UserController::class, 'edit'])->name('edit');
        
        Route::get('agents', [UserController::class, 'agents']);
        Route::get('clients', [UserController::class, 'clients']);
    });

    Route::prefix('tickets')->group(function () {
        Route::get('', [TicketController::class, 'index']);
        Route::post('create', [TicketController::class, 'create']);
        Route::get('view/{id}', [TicketController::class, 'viewOne']);
        Route::put('edit/{id}', [TicketController::class, 'edit']);
        Route::post('quantity', [TicketController::class, 'quantity']);
    });
    Route::prefix('person')->group(function(){
        Route::get('list',[PersonController::class,'list']);
    });

});