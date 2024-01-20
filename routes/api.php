<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InviteRequestController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StudySetController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
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
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])
            ->name('user.profile');
            Route::get('/top_creators', [UserController::class, 'topCreators'])
            ->name('user.top_creators');
    });
    Route::prefix('exam')->group(function () {
        Route::get('/', [TestController::class, 'index'])
            ->name('exam.index');
            
    });
    Route::prefix('study_sets')->group(function () {
        Route::get('/', [StudySetController::class, 'index'])
            ->name('study_sets.list');
            Route::get('/created_sets', [StudySetController::class, 'getCreatedSet'])
            ->name('study_sets.created_sets');
        Route::get('/{id}', [StudySetController::class, 'show'])
            ->name('study_sets.show');
        Route::post('/', [StudySetController::class, 'store'])
            ->name('study_sets.store');
        Route::delete('/{id}', [StudySetController::class, 'delete'])
            ->name('study_sets.delete');
    });
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])
            ->name('courses.list');
        Route::post('/', [CourseController::class, 'store'])
            ->name('courses.store');
        Route::get('/{id}', [CourseController::class, 'show'])
            ->name('courses.show');
        Route::delete('/{id}', [CourseController::class, 'delete'])
            ->name('courses.delete');
        Route::post('/add_study_set', [CourseController::class, 'addStudySet'])
            ->name('courses.add_study_set');
        Route::post('/invite_member', [InviteRequestController::class, 'invite'])
            ->name('courses.invite');
        Route::post('/accept_invite', [InviteRequestController::class, 'acceptInvite'])
            ->name('courses.accept_invite');
            
    });
    Route::get('/search_users', [InviteRequestController::class, 'searchUser'])
            ->name('courses.searchUser');
    Route::get('/get_invites', [InviteRequestController::class, 'getInvite'])
            ->name('courses.getInvite');
    Route::get('/search', [SearchController::class, 'index'])
            ->name('search.index');

    Route::prefix('terms')->group(function () {
        Route::post('/', [TermController::class, 'store'])
        ->name('terms.store');
    });
});

// Route::prefix('study_sets')->group(function () {
//     Route::get('/', [StudySetController::class, 'index'])
//         ->name('study_sets.list');
//     Route::get('/{id}', [StudySetController::class, 'show'])
//         ->name('study_sets.show');
// });

Route::post('/login', [AuthController::class, 'login'])
        ->name('auth.login');

