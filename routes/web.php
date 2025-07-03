<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\ChoferController;
use App\Http\Controllers\AyudanteController;
use App\Http\Controllers\RecoverPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\EncomiendaController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\ViajeController;
use App\Http\Controllers\PasajeController;
use App\Http\Controllers\TurnoController;

Route::redirect('/', '/login');

Route::get('/recover', [RecoverPasswordController::class, 'showForm'])->name('recover.form');
Route::post('/recover/check', [RecoverPasswordController::class, 'check'])->name('recover.check');
Route::get('/recover/question/{ci_usuario}', [RecoverPasswordController::class, 'showQuestion'])->name('recover.question');
Route::post('/recover/validate-answer/{ci_usuario}', [RecoverPasswordController::class, 'validateAnswer'])->name('recover.answer.validate');
Route::get('/recover/reset/{ci_usuario}', [RecoverPasswordController::class, 'showResetForm'])->name('recover.reset.form');
Route::post('/recover/reset/{ci_usuario}', [RecoverPasswordController::class, 'updatePassword'])->name('recover.reset.submit');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

require __DIR__ . '/auth.php';

Route::view('/lobby', 'lobby')->middleware('auth')->name('lobby');

Route::middleware(['auth', 'rol:chofer,ayudante'])->group(function(){
     Route::get('/kardex', [KardexController::class, 'index'])->name('kardex.index');
 });


Route::middleware(['auth', 'rol:admin'])
    ->get('/dashboard', fn() => view('admin.dashboard'))
    ->name('dashboard');

Route::middleware(['auth', 'rol:admin'])->group(function() {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class)->parameters(['users' => 'ci_usuario']);
    Route::resource('buses', BusController::class)->parameters(['buses' => 'bus']);
    Route::resource('rutas', RutaController::class)->parameters(['rutas' => 'ruta']);
    Route::resource('viajes', ViajeController::class)->parameters(['viajes' => 'viaje']);
    Route::resource('choferes', ChoferController::class)->parameters(['choferes' => 'chofer']);
});

Route::middleware(['auth', 'rol:supervisor gral'])
    ->get('/supervisor', [SupervisorController::class, 'index'])
    ->name('supervisor.dashboard');

Route::middleware(['auth', 'rol:cajero'])
    ->get('/cajero', [CajeroController::class, 'index'])
    ->name('cajero.dashboard');

    Route::middleware(['auth', 'rol:admin,supervisor gral,supervisor suc'])
    ->get('/chofer', [ChoferController::class, 'index'])
    ->name('chofer.dashboard');

Route::middleware(['auth', 'rol:chofer'])
    ->get('/chofer', [ChoferController::class, 'index'])
    ->name('chofer.dashboard');




Route::middleware(['auth', 'rol:admin,supervisor gral'])
    ->resource('rutas', RutaController::class)
    ->parameters(['rutas' => 'ruta']);

    Route::middleware(['auth', 'rol:admin,supervisor gral,supervisor suc,cajero,ventas qr,carga,encomienda'])
    ->group(function() {

   Route::get('pasajes',                            [PasajeController::class, 'index'])          ->name('pasajes.index');
   Route::get('pasajes/create',                     [PasajeController::class, 'create'])         ->name('pasajes.create');
   Route::post('pasajes',                           [PasajeController::class, 'store'])          ->name('pasajes.store');
   Route::get('pasajes/confirmar',                  [PasajeController::class, 'confirmar'])      ->name('pasajes.confirmar');
   Route::get('pasajes/finalizar',                  [PasajeController::class, 'finalizar'])      ->name('pasajes.finalizar');

   Route::get('pasajes/{viaje}/disponibilidad',     [PasajeController::class, 'disponibilidad'])
        ->whereNumber('viaje')
        ->name('pasajes.disponibilidad');
        Route::get('viajes/{viaje}/cierre',      [PasajeController::class, 'cierre'])
        ->whereNumber('viaje')
        ->name('viajes.cierre');
   Route::post('viajes/{viaje}/cerrar',     [PasajeController::class, 'cerrar'])
        ->whereNumber('viaje')
        ->name('viajes.cerrar');

   Route::get('viajes/{viaje}/plantilla',   [PasajeController::class, 'plantilla'])
        ->whereNumber('viaje')
        ->name('viajes.plantilla');


   Route::get('pasajes/{pasaje}',                   [PasajeController::class, 'show'])
        ->whereNumber('pasaje')
        ->name('pasajes.show');
   Route::put('pasajes/{pasaje}',                   [PasajeController::class, 'update'])
        ->whereNumber('pasaje')
        ->name('pasajes.update');
   Route::delete('pasajes/{pasaje}',                [PasajeController::class, 'destroy'])
        ->whereNumber('pasaje')
        ->name('pasajes.destroy');
   Route::get('pasajes/{pasaje}/ticket',            [PasajeController::class, 'ticket'])
        ->whereNumber('pasaje')
        ->name('pasajes.ticket');

   Route::get('pasajes/viajes-por-fecha',           [PasajeController::class, 'viajesPorFecha'])
        ->name('pasajes.viajesPorFecha');
   Route::get('pasajes/vendidos/{viaje}',           [PasajeController::class, 'verVendidosPorViaje'])
        ->whereNumber('viaje')
        ->name('pasajes.vendidosPorViaje');
});


Route::middleware(['auth', 'rol:admin,supervisor gral,supervisor suc,cajero,ventas qr,carga,encomienda'])
    ->group(function() {
        Route::resource('carga', CargaController::class)->only(['index', 'create', 'show', 'edit']);
        Route::post('carga', [CargaController::class, 'store'])->name('carga.store');
        Route::put('carga/{carga}', [CargaController::class, 'update'])->name('carga.update');
        Route::get('carga/{carga}/pdf', [CargaController::class, 'pdf'])->name('carga.pdf');
    });

Route::middleware(['auth', 'rol:admin,supervisor gral,supervisor suc,cajero,ventas qr,carga,encomienda'])
    ->group(function() {
        Route::get('turnos', [TurnoController::class, 'index'])->name('turnos.index');
        Route::post('turnos/{turno}/close', [TurnoController::class, 'close'])->name('turnos.close');
    });

Route::middleware(['auth', 'rol:admin,supervisor gral,supervisor suc,cajero,ventas qr,carga,encomienda'])
    ->prefix('encomiendas')
    ->as('encomiendas.')
    ->group(function () {
        Route::get('/', [EncomiendaController::class, 'index'])->name('index');
        Route::get('create', [EncomiendaController::class, 'create'])->name('create');
        Route::post('/', [EncomiendaController::class, 'store'])->name('store');
        Route::get('{encomienda}', [EncomiendaController::class, 'show'])->name('show');
        Route::get('{encomienda}/edit', [EncomiendaController::class, 'edit'])->name('edit');
        Route::put('{encomienda}', [EncomiendaController::class, 'update'])->name('update');
        Route::delete('{encomienda}', [EncomiendaController::class, 'destroy'])->name('destroy');
        Route::get('{encomienda}/pdf', [EncomiendaController::class, 'pdf'])->name('pdf');
    });
