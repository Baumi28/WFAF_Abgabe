<?php

use App\Http\Controllers\PadletController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\RatingController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [AuthController::class, 'login']);


Route::get("padlets", [PadletController::class, 'index']);
Route::get("padlets/{id}", [PadletController::class, 'findByID']);
Route::get("padlets/{id}/entries", [EntryController::class, 'showEntriesOfPadlet']);
//Route::get("padlets/checkid/{id}", [PadletController::class, 'checkID']);
Route::get("entries", [EntryController::class, 'loadEntries']);
Route::get("users", [UserController::class, 'loadUsers']);
Route::get('entries/{id}/comments', [EntryController::class, 'showCommentsOfEntry']);
Route::get('entries/{id}/ratings', [EntryController::class, 'showRatingsOfEntry']);

Route::group(['middleware'=>['api', 'auth.jwt']], function(){
    Route::post('padlets', [PadletController::class,'createPadlet']);
    Route::post('entries', [EntryController::class,'createEntry']);
    Route::post('users', [UserController::class,'createUser']);
    Route::post('comments', [CommentController::class,'createComment']);
    Route::post('ratings', [RatingController::class,'createRating']);

    Route::put('padlets/{id}', [PadletController::class,'updatePadlet']);
    Route::put('entries/{id}', [EntryController::class,'updateEntry']);

    Route::delete('padlets/{id}', [PadletController::class,'deletePadlet']);
    Route::delete('entries/{id}', [EntryController::class,'deleteEntry']);
    Route::delete('users/{id}', [UserController::class,'deleteUser']);
    Route::delete('comments/{id}', [CommentController::class,'deleteComment']);
    Route::delete('ratings/{id}', [RatingController::class,'deleteRating']);

    Route::post('auth/logout', [AuthController::class, 'logout']);
});


