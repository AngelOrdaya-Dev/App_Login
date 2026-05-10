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

Route::get('/auth/{provider}/redirect', [LoginController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/{provider}-callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ScheduleController;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas Administrativas
    Route::middleware(['admin'])->group(function () {
        Route::get('/estudiantes', [SectionController::class, 'students'])->name('students');
        Route::post('/estudiantes', [SectionController::class, 'storeStudent'])->name('students.store');
        Route::delete('/estudiantes/{user}', [SectionController::class, 'destroyStudent'])->name('students.destroy');
        
        Route::get('/aulas', [SectionController::class, 'classrooms'])->name('classrooms');
        Route::post('/aulas', [SectionController::class, 'storeClassroom'])->name('classrooms.store');
        Route::delete('/aulas/{classroom}', [SectionController::class, 'destroyClassroom'])->name('classrooms.destroy');
        
        Route::get('/carreras', [SectionController::class, 'careers'])->name('careers');
        Route::post('/carreras', [SectionController::class, 'storeCareer'])->name('careers.store');
        Route::delete('/carreras/{career}', [SectionController::class, 'destroyCareer'])->name('careers.destroy');

        Route::get('/exportar/estudiantes', [SectionController::class, 'exportStudents'])->name('export.students');
        Route::get('/exportar/aulas', [SectionController::class, 'exportClassrooms'])->name('export.classrooms');
        Route::post('/pagos/{payment}/aprobar', [SectionController::class, 'approvePayment'])->name('payments.approve');

        // Gestión de Docentes
        Route::get('/docentes', [SectionController::class, 'teachers'])->name('teachers');
        Route::post('/docentes', [SectionController::class, 'storeTeacher'])->name('teachers.store');
        Route::delete('/docentes/{user}', [SectionController::class, 'destroyTeacher'])->name('teachers.destroy');

        // Horarios (admin)
        Route::post('/horarios', [ScheduleController::class, 'store'])->name('schedules.store');
        Route::delete('/horarios/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

        // Notas Administrativas
        Route::post('/notas/{grade}', [SectionController::class, 'updateGrade'])->name('grades.update');
        Route::delete('/notas/{grade}', [SectionController::class, 'destroyGrade'])->name('grades.destroy');

        // Auditoría y Reportes
        Route::get('/auditoria', [SectionController::class, 'auditLogs'])->name('audit.logs');
        Route::get('/reportes', [SectionController::class, 'reports'])->name('reports.index');
        Route::get('/cursos', [SectionController::class, 'coursesIndex'])->name('courses.index');
        Route::post('/cursos/{course}/assign-teacher', [SectionController::class, 'assignTeacher'])->name('courses.assign');
    });

    // Rutas para Docentes (y Admin puede acceder también)
    Route::middleware(['teacher'])->group(function () {
        Route::get('/mis-cursos', [TeacherController::class, 'courses'])->name('teacher.courses');
        Route::get('/asistencia/{course}', [ScheduleController::class, 'attendance'])->name('attendance.form');
        Route::post('/asistencia/{course}', [ScheduleController::class, 'saveAttendance'])->name('attendance.save');
    });

    // Horarios (todos los roles)
    Route::get('/horarios', [ScheduleController::class, 'index'])->name('schedules');

    Route::get('/inscripciones', [SectionController::class, 'enrollments'])->name('enrollments');
    Route::post('/inscripciones', [SectionController::class, 'storeEnrollment'])->name('enrollments.store');
    Route::get('/inscripciones/{id}/pdf', [SectionController::class, 'downloadEnrollmentPDF'])->name('enrollments.pdf');
    
    Route::get('/pagos', [SectionController::class, 'payments'])->name('payments');
    Route::get('/pagos/{id}/pdf', [SectionController::class, 'downloadPaymentPDF'])->name('payments.pdf');
    
    Route::get('/notas', [SectionController::class, 'grades'])->name('grades');
    Route::post('/notas', [SectionController::class, 'storeGrade'])->name('grades.store');

    Route::get('/configuracion', [SectionController::class, 'settings'])->name('settings');
    
    // Profile Updates
    Route::post('/perfil/actualizar', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/perfil/eliminar-avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
    Route::post('/perfil/seguridad', [ProfileController::class, 'updateSecurity'])->name('profile.security');
    Route::post('/perfil/cambiar-password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/perfil/actualizar-carrera', [ProfileController::class, 'updateCareer'])->name('profile.update.career');
    
    // Notifications & Search
    Route::post('/notificaciones/{id}/leer', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notificaciones/configuracion', [NotificationController::class, 'toggleSettings'])->name('notifications.settings');
    Route::get('/buscar', [SearchController::class, 'globalSearch'])->name('search.global');

    // Biblioteca Digital
    Route::get('/biblioteca', [\App\Http\Controllers\MaterialController::class, 'index'])->name('library.index');
    Route::post('/biblioteca', [\App\Http\Controllers\MaterialController::class, 'store'])->name('library.store');
    Route::delete('/biblioteca/{material}', [\App\Http\Controllers\MaterialController::class, 'destroy'])->name('library.destroy');

    // Clases Virtuales
    Route::get('/clases-virtuales', [SectionController::class, 'virtualClasses'])->name('virtual.classes');

    // Autenticación de Dos Factores
    Route::get('/verificar-2fa', [App\Http\Controllers\Auth\TwoFactorController::class, 'index'])->name('verify.index');
    Route::post('/verificar-2fa', [App\Http\Controllers\Auth\TwoFactorController::class, 'store'])->name('verify.store');
    Route::get('/verificar-2fa/reenviar', [App\Http\Controllers\Auth\TwoFactorController::class, 'resend'])->name('verify.resend');
});
