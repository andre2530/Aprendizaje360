<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\DocenteCsvController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\RegistroDocenteController;
use App\Http\Controllers\DocenteController;

// Redirección a Filament por defecto
Route::redirect('/admin', '/admin/dashboard-docente');

// Página inicial redirige al login
Route::get('/', fn () => redirect()->route('login'));

// Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registro de docentes
Route::get('/registro-docente', [RegistroDocenteController::class, 'showForm'])->name('docente.registro.form');
Route::post('/registro-docente', [RegistroDocenteController::class, 'register'])->name('docente.registrar');

// Dashboard dinámico según el rol
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->rol) {
        'director' => redirect()->route('director.panel'),
        'docente'  => redirect()->route('docente.panel'),
        default    => abort(403),
    };
})->name('dashboard');

// Panel del Director
Route::middleware('auth')->get('/director/panel', [DirectorController::class, 'index'])->name('director.panel');

// Panel del Docente
Route::get('/docente/panel', [DocenteController::class, 'panel'])
    ->middleware('auth')
    ->name('docente.panel');
// Funcionalidades protegidas
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Subida de CSV y reportes
    Route::get('/docente/subir-csv', [DocenteCsvController::class, 'form'])->name('docente.csv.form');
    Route::post('/docente/subir-csv', [DocenteCsvController::class, 'importar'])->name('docente.subir.csv');
    Route::get('/docente/estudiantes', [DocenteCsvController::class, 'verEstudiantes'])->name('docente.estudiantes');
    Route::get('/docente/reporte-pdf', [ReporteController::class, 'generarPdf'])->name('docente.reporte.pdf');
    Route::get('/director/reporte/pdf', [ReporteController::class, 'generarPdfDirector'])->name('director.reporte.pdf');


});

// Gestión de grados y secciones
Route::get('/grados', [GradoController::class, 'index'])->name('grados.index');
Route::post('/grados', [GradoController::class, 'store'])->name('grados.store');

Route::get('/secciones', [SeccionController::class, 'index'])->name('secciones.index');
Route::post('/secciones', [SeccionController::class, 'store'])->name('secciones.store');

// Asignación de docente a grado y sección
Route::get('/asignar-docente', [AsignacionController::class, 'index'])->name('asignar.index');
Route::post('/asignar-docente', [AsignacionController::class, 'store'])->name('asignar.store');
Route::post('/docente/estudiantes/eliminar', [DocenteCsvController::class, 'eliminarEstudiantes'])->name('docente.eliminar.estudiantes');
// Breeze, Fortify o Auth scaffolding
require __DIR__.'/auth.php';
