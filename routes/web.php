<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* ... */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences.update');


    // Rotas para o gerenciamento de Treinos
    Route::get('/treinos', [TrainingController::class, 'index'])->name('trainings.index');
    Route::get('/treinos/criar', [TrainingController::class, 'create'])->name('trainings.create');
    Route::post('/treinos', [TrainingController::class, 'store'])->name('trainings.store');
    Route::get('/treinos/{training}', [TrainingController::class, 'show'])->name('trainings.show');
    Route::delete('/treinos/{training}', [TrainingController::class, 'destroy'])->name('trainings.destroy');
    Route::get('/treinos/{training}/editar', [TrainingController::class, 'edit'])->name('trainings.edit');
    Route::patch('/treinos/{training}', [TrainingController::class, 'update'])->name('trainings.update');

    // =========================================================================
    // == NOVAS ROTAS PARA O DIÁRIO DE TREINOS ==
    // =========================================================================
    Route::post('/treinos/{training}/complete', [TrainingController::class, 'completeSession'])->name('trainings.completeSession');
    Route::get('/treinos/{training}/historico', [TrainingController::class, 'history'])->name('trainings.history');


    // Rotas para o gerenciamento de Exercícios
    Route::get('/treinos/{training}/exercicios/criar', [TrainingController::class, 'createExercise'])->name('exercises.create');
    Route::post('/treinos/{training}/exercicios', [TrainingController::class, 'storeExercise'])->name('exercises.store');
    Route::get('/treinos/{training}/exercicios/{exercise}/editar', [TrainingController::class, 'editExercise'])->name('exercises.edit');
    Route::patch('/treinos/{training}/exercicios/{exercise}', [TrainingController::class, 'updateExercise'])->name('exercises.update');
    Route::delete('/treinos/{training}/exercicios/{exercise}', [TrainingController::class, 'destroyExercise'])->name('exercises.destroy');
    
    // Rota antiga foi removida, pois não é mais necessária.
    // Route::patch('/treinos/{training}/exercicios/{exercise}/complete', ...);


    // Rotas para o gerenciamento de Medidas Corporais
    Route::get('/medidas', [MeasurementController::class, 'index'])->name('measurements.index');
    Route::get('/medidas/criar', [MeasurementController::class, 'create'])->name('measurements.create');
    // ... (demais rotas de medidas)

    // Nova rota para a página de progresso
    Route::get('/progresso', [MeasurementController::class, 'progress'])->name('measurements.progress');
    
    });

require __DIR__.'/auth.php';