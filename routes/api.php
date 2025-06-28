<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingResourceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\FinancialStatusController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\PostTrainingEventController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingCostController;
use App\Http\Controllers\TypeTrainingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public route (ex: login)
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // CRUD básico para cada entidade no sistema
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('instructors', InstructorController::class);
    Route::apiResource('trainings', TrainingController::class);
    Route::apiResource('resources', ResourceController::class);
    Route::apiResource('costs', CostController::class);
    Route::apiResource('type-trainings', TypeTrainingController::class);
    Route::apiResource('status', StatusController::class);
    Route::apiResource('financial_status', FinancialStatusController::class);
    Route::apiResource('post-training-events', PostTrainingEventController::class);

    // Relacionamentos pivot
    Route::prefix('trainings/{training}')->group(function () {
        Route::get('/resources', [BookingResourceController::class, 'index']);
        Route::post('/resources', [BookingResourceController::class, 'store']);
        Route::put('/resources/{booking_resource}', [BookingResourceController::class, 'update']);
        Route::delete('/resources/{booking_resource}', [BookingResourceController::class, 'destroy']);
    });

    Route::prefix('trainings/{training}')->group(function () {
        Route::get('/costs', [TrainingCostController::class, 'index']);
        Route::post('/costs', [TrainingCostController::class, 'store']);
        Route::put('/costs/{training_cost}', [TrainingCostController::class, 'update']);
        Route::delete('/costs/{training_cost}', [TrainingCostController::class, 'destroy']);
    });

    // Usuário autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});
