<?php

use App\Http\Controllers\ApiController;
use App\Http\Middleware\CheckToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware([CheckToken::class])->group(function () {
    Route::get('/calendar', [ApiController::class, 'index']);
    Route::get('/calendar-events', [ApiController::class, 'getEvents']);
    Route::post('/add/calendar-events', [ApiController::class, 'addEvents']);
    Route::put('/update/calendar-events/{id}', [ApiController::class, 'update']);
    Route::delete('/delete/calendar-events/{eventId}', [ApiController::class, 'deleteEvent']);
});