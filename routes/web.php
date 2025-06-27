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
use App\Http\Controllers\StopController;
use App\Http\Controllers\RutaStopController;

Route::redirect('/', '/login');

Route::get('/recover',       [RecoverPasswordController::class, 'showForm'])->name('recover.form');
Route::post('/recover/check',[RecoverPasswordController::class, 'check'])->name('recover.check');
Route::get('/recover/question/{ci_usuario}',     [RecoverPasswordController::class, 'showQuestion'])->name('recover.question');
Route::post('/recover/validate-answer/{ci_usuario}', [RecoverPasswordController::class, 'validateAnswer'])->name('recover.answer.validate');
Route::get('/recover/reset/{ci_usuario}',        [RecoverPasswordController::class, 'showResetForm'])->name('recover.reset.form');
Route::post('/recover/reset/{ci_usuario}',       [RecoverPasswordController::class, 'updatePassword'])->name('recover.reset.submit');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';


Route::view('/lobby', 'lobby')
     ->middleware('auth')
     ->name('lobby');

Route::middleware(['auth','rol:admin'])
     ->get('/dashboard', fn() => view('admin.dashboard'))
     ->name('dashboard');

Route::middleware(['auth','rol:admin'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('users',    UserController::class);
    Route::resource('buses',    BusController::class)->parameters(['buses' => 'bus']);
    Route::resource('rutas',    RutaController::class)->parameters(['rutas' => 'ruta']);
    Route::resource('viajes',   ViajeController::class)->parameters(['viajes' => 'viaje']);
    Route::resource('choferes', ChoferController::class)->parameters(['choferes' => 'chofer']);
});

Route::middleware(['auth','rol:supervisor gral'])
     ->get('/supervisor', [SupervisorController::class, 'index'])
     ->name('supervisor.dashboard');

Route::middleware(['auth','rol:cajero'])
     ->get('/cajero', [CajeroController::class, 'index'])
     ->name('cajero.dashboard');
Route::middleware(['auth','rol:admin,supervisor gral,supervisor suc'])->group(function(){
    Route::get('/chofer',   [ChoferController::class, 'index'])->name('chofer.dashboard');
    Route::get('/ayudante', [AyudanteController::class, 'index'])->name('ayudante.dashboard');
});

Route::middleware('auth')->group(function(){
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth','rol:admin,supervisor gral,cajero,carga,ventas qr'])
     ->resource('pasajes', PasajeController::class);

Route::middleware(['auth','rol:admin,supervisor gral,cajero,carga,ventas qr'])
     ->resource('carga', CargaController::class);

Route::middleware(['auth','rol:admin,supervisor gral,cajero,encomienda,ventas qr,carga'])
     ->resource('encomiendas', EncomiendaController::class);

Route::middleware(['auth','rol:chofer y ayudante'])
     ->resource('kardex', KardexController::class);

Route::middleware(['auth','rol:admin,supervisor gral']) 
     ->resource('stops', StopController::class)
     ->parameters(['stops' => 'stop']);

Route::middleware(['auth','rol:admin,supervisor gral']) 
     ->resource('rutas', RutaController::class)
     ->parameters(['rutas' => 'ruta']);

Route::middleware(['auth','rol:admin,supervisor gral'])
     ->resource('ruta_stop', RutaStopController::class)
     ->shallow()
     ->parameters([
         'rutas' => 'ruta',
         'stops' => 'stop',
     ]);

