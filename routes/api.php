<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\MoodController;
use App\Http\Controllers\Api\StreakController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\ForgotPasswordController;

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



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/streak', [StreakController::class, 'streak']);
    Route::get('/moods', [MoodController::class, 'index']);

    Route::apiResource('journals', JournalController::class);
    Route::get('/statistics', [StatisticController::class, 'entries']);
    Route::get('/statistics/words', [StatisticController::class, 'wordsWritten']);
    Route::get('/statistics/common-mood', [StatisticController::class, 'commonMoods']);
    Route::get('/statistics/writing-rhythm', [StatisticController::class, 'writingRhythm']);
    Route::get('/statistics/active-days', [StatisticController::class, 'activeDays']);
    Route::get('/profile/{user}', [UserController::class, 'show']);
    Route::patch('/profile/{user}', [UserController::class, 'updateProfile']);

    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('moods', MoodController::class)->except(['index']);
        Route::get('/users', [UserController::class, 'index']);
    });
});
