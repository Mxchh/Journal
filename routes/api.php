<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\StreakController;
use App\Models\Journal;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\StatisticController;

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
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/streak', [StreakController::class, 'streak']);

    Route::apiResource('journals', JournalController::class);
    Route::get('/statistics', [StatisticController::class, 'entries']);
    Route::get('/statistics/words', [StatisticController::class,'wordsWritten']);
    Route::get('/statistics/common-mood', [StatisticController::class, 'commonMoods']);
        Route::get('/statistics/writing-rhythm', [StatisticController::class, 'writingRhythm']);
            Route::get('/statistics/active-days', [StatisticController::class, 'activeDays']);

    Route::middleware(['role:admin'])->group(function(){
        Route::get('/users', [UserController::class, 'index']);
    });
});
