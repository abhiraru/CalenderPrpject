<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalenderController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/calendar', [CalenderController::class, 'index']);
Route::get('/calendar-events', [CalenderController::class, 'getEvents']);
Route::post('/add/calendar-events', [CalenderController::class, 'addEvents']);
Route::put('/update/calendar-events/{id}', [CalenderController::class, 'update']);
Route::delete('/delete/calendar-events/{eventId}', [CalenderController::class, 'deleteEvent']);
