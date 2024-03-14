<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/

Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //gestion de usuarios 
    Route::get('/ver-usuarios',[UserController::class, 'index'])->name('ver.usuarios');
    Route::get('/crear-usuarios',[UserController::class, 'getViewUser'])->name('crear.usuarios');
    Route::post('/guardar-usuarios', [UserController::class, 'store'])->name('guardar.usuarios');

    //gestionde cursos
    Route::get('/ver-cursos',[CourseController::class, 'index'])->name('ver.cursos');
    Route::get('/crear-cursos',[CourseController::class, 'getViewCursos'])->name('crear.cursos');
    Route::get('/ver.cursosa', [CourseController::class, 'getViewCusrsosAsosiados'])->name('ver.cursosa');  
    Route::post('/guardar-cursos', [CourseController::class, 'store'])->name('guardar.cursos');
    Route::post('/guardar-asociados', [CourseController::class, 'storeAsoiado'])->name('guardar.asociados');
  

});
