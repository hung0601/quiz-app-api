<?php

use App\Http\Controllers\StudySetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('study_sets')->group(function () {
    Route::get('/', [StudySetController::class, 'index'])
        ->name('study_sets.list');
    Route::get('/{id}', [StudySetController::class, 'show'])
        ->name('study_sets.show');
});

