<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackHistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/offline', function () {
    return view('offline');
})->name('offline');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences.update');
    Route::patch('/profile/link-personal', [ProfileController::class, 'linkPersonal'])->name('profile.linkPersonal');

    Route::get('/historico-feedbacks', [FeedbackHistoryController::class, 'index'])->name('feedback.history');


    // Rotas para a Área do Personal Trainer
    Route::middleware('role:personal')->prefix('personal')->name('personal.')->group(function () {
        Route::get('/alunos', [PersonalController::class, 'index'])->name('students.index');
        Route::get('/alunos/{aluno}/treinos', [PersonalController::class, 'showStudentTrainings'])->name('students.trainings');
        
        // =========================================================================
        // == NOVAS ROTAS PARA O PERSONAL CRIAR TREINOS PARA O ALUNO ==
        // =========================================================================
        Route::get('/alunos/{aluno}/treinos/criar', [PersonalController::class, 'createStudentTraining'])->name('students.trainings.create');
        Route::post('/alunos/{aluno}/treinos', [PersonalController::class, 'storeStudentTraining'])->name('students.trainings.store');

        // =========================================================================
        // == NOVAS ROTAS PARA O PERSONAL GERENCIAR EXERCÍCIOS DE UM ALUNO ==
        // =========================================================================
        Route::get('/alunos/{aluno}/treinos/{training}', [PersonalController::class, 'showStudentTrainingDetails'])->name('students.trainings.show');
        Route::get('/alunos/{aluno}/treinos/{training}/exercicios/criar', [PersonalController::class, 'createStudentExercise'])->name('students.exercises.create');
        Route::post('/alunos/{aluno}/treinos/{training}/exercicios', [PersonalController::class, 'storeStudentExercise'])->name('students.exercises.store');
        Route::get('/alunos/{aluno}/treinos/{training}/exercicios/{exercise}/editar', [PersonalController::class, 'editStudentExercise'])->name('students.exercises.edit');
        Route::patch('/alunos/{aluno}/treinos/{training}/exercicios/{exercise}', [PersonalController::class, 'updateStudentExercise'])->name('students.exercises.update');
        Route::delete('/alunos/{aluno}/treinos/{training}/exercicios/{exercise}', [PersonalController::class, 'destroyStudentExercise'])->name('students.exercises.destroy');
    });


    // Rotas para o gerenciamento de Treinos
    Route::get('/treinos', [TrainingController::class, 'index'])->name('trainings.index');
    Route::get('/treinos/criar', [TrainingController::class, 'create'])->name('trainings.create');
    Route::post('/treinos', [TrainingController::class, 'store'])->name('trainings.store');
    Route::get('/treinos/{training}', [TrainingController::class, 'show'])->name('trainings.show');
    Route::delete('/treinos/{training}', [TrainingController::class, 'destroy'])->name('trainings.destroy');
    Route::get('/treinos/{training}/editar', [TrainingController::class, 'edit'])->name('trainings.edit');
    Route::patch('/treinos/{training}', [TrainingController::class, 'update'])->name('trainings.update');

    // Rotas para o Diário de Treinos
    Route::post('/treinos/{training}/complete', [TrainingController::class, 'completeSession'])->name('trainings.completeSession');
    Route::get('/treinos/{training}/historico', [TrainingController::class, 'history'])->name('trainings.history');


    // Rotas para o gerenciamento de Exercícios
    Route::get('/treinos/{training}/exercicios/criar', [TrainingController::class, 'createExercise'])->name('exercises.create');
    Route::post('/treinos/{training}/exercicios', [TrainingController::class, 'storeExercise'])->name('exercises.store');
    Route::get('/treinos/{training}/exercicios/{exercise}/editar', [TrainingController::class, 'editExercise'])->name('exercises.edit');
    Route::patch('/treinos/{training}/exercicios/{exercise}', [TrainingController::class, 'updateExercise'])->name('exercises.update');
    Route::delete('/treinos/{training}/exercicios/{exercise}', [TrainingController::class, 'destroyExercise'])->name('exercises.destroy');
    Route::patch('/treinos/{training}/exercicios/reorder', [TrainingController::class, 'reorderExercises'])->name('exercises.reorder');


    // Rotas para o gerenciamento de Medidas Corporais
    Route::get('/medidas', [MeasurementController::class, 'index'])->name('measurements.index');
    Route::get('/medidas/criar', [MeasurementController::class, 'create'])->name('measurements.create');
    Route::post('/medidas', [MeasurementController::class, 'store'])->name('measurements.store');
    Route::get('/medidas/{measurement}', [MeasurementController::class, 'show'])->name('measurements.show');
    Route::get('/medidas/{measurement}/editar', [MeasurementController::class, 'edit'])->name('measurements.edit');
    Route::patch('/medidas/{measurement}', [MeasurementController::class, 'update'])->name('measurements.update');
    Route::delete('/medidas/{measurement}', [MeasurementController::class, 'destroy'])->name('measurements.destroy');

    // Rota para a página de progresso
    Route::get('/progresso', [MeasurementController::class, 'progress'])->name('measurements.progress');
    
});

require __DIR__.'/auth.php';