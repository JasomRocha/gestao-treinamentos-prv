<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trainings/create', [TrainingsController::class, 'create']);
Route::get('/trainings/read', [TrainingsController::class, 'read']);
Route::get('/trainings/all', [TrainingsController::class, 'all']);
Route::get('trainings/update', [TrainingsController::class, 'update']);
Route::get('trainings/delete', [TrainingsController::class, 'delete']);


