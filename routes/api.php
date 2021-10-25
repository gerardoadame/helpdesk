<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    TicketController,
    UserController,
    PersonController,
    ActiveController,
    AreaController
};

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
    Route::post('login', [AuthController::class, 'login']);

    Route::get('password/reset/{email}/{token}', function ($token, $email) {
        return redirect()->away('http://localhost:4200/password-reset/'.urlencode($email).'/'.$token);
    })->name('password.reset');

    Route::post('password/forgot', [AuthController::class, 'forgotPassword']);
    Route::post('password/reset', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:api')->group(function () {

    Route::get('auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('areas', AreaController::class);

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

        Route::get('',[PersonController::class,'list']);
        Route::get('view/{id}',[PersonController::class,'viewperson']);
        Route::put('edit/{id}',[PersonController::class,'Editperson']);
        Route::get('list',[PersonController::class,'list']);
        Route::get('viewperson/{id}',[PersonController::class,'viewperson']);
        Route::post('edit',[PersonController::class,'Editperson']);

    });

    Route::prefix('active')->group(function(){
        Route::get('list',[ActiveController::class,'list']);
        Route::put('create', [ActiveController::class,'create']);
        Route::get('viewactive/{id}',[ActiveController::class,'viewactive']);
        Route::post('edit/{id}',[ActiveController::class,'Edit']);
    });

});
