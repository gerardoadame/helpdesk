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
| IMPORTANT!!!
| * This app is an API, to add web routes you will need to uncomment some
| services in the "web" middleware group
| * Esta app es una API, para aniadir rutas web tendras que descomentar algunos
| servicios en el grupo de middleware "web"
*/

Route::get('/', function () { return view('welcome'); });
