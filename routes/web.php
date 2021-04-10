<?php

use Illuminate\Support\Facades\Route;

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
Route::get('view_ticket_emp','App\Http\Controllers\EmpleadoController@viewTickets');

Route::post('remove','App\Http\Controllers\EmpleadoController@removeTicket');

Route::post('update_emp','App\Http\Controllers\EmpleadoController@updateTicket');

#Rutas del Tecnico
Route::get('view_ticket_tec','App\Http\Controllers\TecController@viewTickets');
Route::post('remove','App\Http\Controllers\TecController@remove');
Route::post('update_tec','App\Http\Controllers\TecController@updateTicket');


