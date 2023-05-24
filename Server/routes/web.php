<?php

use App\Http\Controllers\PadletController;
use \App\Http\Controllers\EntryController;
use \App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Padlet;
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

//Wenn Nutzer auf Root geht, geh auf die index Methode im PadletController
Route::get('/', [PadletController::class, 'index']);

Route::get('/padlets', [PadletController::class, 'index']);

Route::get('/padlets/{padletId}', [PadletController::class,'show']);

