<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login-google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/google-callback', [LoginController::class, 'handleGoogleCallback']);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/estudiantes', [SectionController::class, 'students'])->name('students');
    Route::post('/estudiantes', [SectionController::class, 'storeStudent'])->name('students.store');
    Route::delete('/estudiantes/{user}', [SectionController::class, 'destroyStudent'])->name('students.destroy');
    
    Route::get('/aulas', [SectionController::class, 'classrooms'])->name('classrooms');
    Route::post('/aulas', [SectionController::class, 'storeClassroom'])->name('classrooms.store');
    Route::delete('/aulas/{classroom}', [SectionController::class, 'destroyClassroom'])->name('classrooms.destroy');
    
    Route::get('/carreras', [SectionController::class, 'careers'])->name('careers');
    Route::post('/carreras', [SectionController::class, 'storeCareer'])->name('careers.store');
    Route::delete('/carreras/{career}', [SectionController::class, 'destroyCareer'])->name('careers.destroy');
    Route::get('/inscripciones', [SectionController::class, 'enrollments'])->name('enrollments');
    Route::get('/pagos', [SectionController::class, 'payments'])->name('payments');
    Route::get('/configuracion', [SectionController::class, 'settings'])->name('settings');
    
    // Exports
    Route::get('/exportar/estudiantes', [SectionController::class, 'exportStudents'])->name('export.students');
    Route::get('/exportar/aulas', [SectionController::class, 'exportClassrooms'])->name('export.classrooms');
    
    // Profile Updates
    Route::post('/perfil/actualizar', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/perfil/eliminar-avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});
