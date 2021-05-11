<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('files', function(){
    return view('upload');
});

Route::get('datos','App\Http\Controllers\Controller@datos');

//Pruebas
Route::get('/token',function()
{
    return csrf_field();
});
#Rutas del empleado

#Rutas de tickets
Route::post('obtener',[TicketController::class,'index']);
Route::post('quantity',[TicketController::class,'quantity']);
Route::post('create',[TicketController::class,'create']);
#Rutas de Persona
Route::get('list',[PersonController::class,'list']);
Route::get('l',[PersonController::class,'Viewperson']);


