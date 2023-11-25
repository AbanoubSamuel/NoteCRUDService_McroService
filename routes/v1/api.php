<?php


use App\Http\Middleware\AuthUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "v1" middleware group. Make something great!
|
*/
Route::middleware(AuthUser::class)->group(function () {
    Route::post('/notes', [NoteController::class, 'createNote']);

    Route::patch('/notes', [NoteController::class, 'updateNote']);

    Route::delete('/notes', [NoteController::class, 'deleteNote']);

    Route::get('/notes', [NoteController::class, 'getNotes']);

    Route::get('/note', [NoteController::class, 'getNoteById']);
});