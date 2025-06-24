<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\ChoferController;
use App\Http\Controllers\AyudanteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecoverPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasajeController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\EncomiendaController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\ViajeController;

Route::redirect('/', '/login');

Route::get('/recover', [RecoverPasswordController::class, 'showForm'])->name('recover.form');
Route::get('/recover/question/{ci_usuario}', [RecoverPasswordController::class, 'showQuestion'])->name('recover.question');
Route::post('/recover/validate-answer/{ci_usuario}', [RecoverPasswordController::class, 'validateAnswer'])->name('recover.answer.validate');
Route::post('/recover/check', [RecoverPasswordController::class, 'check'])->name('recover.check');
Route::post('/recover/reset/{ci_usuario}', [RecoverPasswordController::class, 'updatePassword'])->name('recover.reset.submit');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__.'/auth.php';

Route::middleware(['auth','rol:admin'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth','rol:supervisor gral'])->group(function(){
    Route::get('/supervisor', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
});

Route::middleware(['auth','rol:cajero'])->group(function(){
    Route::get('/cajero', [CajeroController::class, 'index'])->name('cajero.dashboard');
});

Route::middleware(['auth','rol:chofer y ayudante'])->group(function(){
    Route::get('/chofer',    [ChoferController::class, 'index'])->name('chofer.dashboard');
    Route::get('/ayudante',  [AyudanteController::class, 'index'])->name('ayudante.dashboard');
});

Route::middleware('auth')->group(function(){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth','rol:admin,supervisor gral'])->group(function(){
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('users', UserController::class);
});

Route::middleware(['auth','rol:admin,supervisor gral,cajero'])->resource('pasajes', PasajeController::class);
Route::middleware(['auth','rol:admin,supervisor gral,carga'])->resource('carga', CargaController::class);
Route::middleware(['auth','rol:admin,supervisor gral,encomienda'])->resource('encomiendas', EncomiendaController::class);
Route::middleware(['auth','rol:chofer y ayudante'])->resource('kardex', KardexController::class);

Route::middleware(['auth','rol:admin'])->group(function(){
    Route::resource('buses',    BusController::class);
    Route::resource('rutas',    RutaController::class);
    Route::resource('viajes',   ViajeController::class);
    Route::resource('choferes', ChoferController::class);
});
