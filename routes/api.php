<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\{LogController, TicketController, UserController,PersonController};
=======
use App\Http\Controllers\{LogController, TicketController, UserController, PersonController, ActiveController};
>>>>>>> de650b894cba40b3dd86856e8584609ab96da4dc

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
    Route::post('signup', [LogController::class, 'signUp']);
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
        Route::post('rate/{id}', [TicketController::class, 'rate']);
        Route::put('reply/{id}',[TicketController::class, 'reply']);
        Route::put('edtreply',[TicketController::class, 'editreply']);
    });

    Route::prefix('person')->group(function(){
<<<<<<< HEAD
        Route::get('',[PersonController::class,'list']);
        Route::get('view/{id}',[PersonController::class,'viewperson']);
        Route::put('edit/{id}',[PersonController::class,'Editperson']);

=======
        Route::get('list',[PersonController::class,'list']);
        Route::get('viewperson/{id}',[PersonController::class,'viewperson']);
        Route::post('edit',[PersonController::class,'Editperson']);
>>>>>>> de650b894cba40b3dd86856e8584609ab96da4dc
    });

    Route::prefix('active')->group(function(){
        Route::put('create', [ActiveController::class,'create']);
        Route::get('viewactive/{id}',[ActiveController::class,'viewactive']);
        // Route::post('edit',[PersonController::class,'Editperson']);
    });

});