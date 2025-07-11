<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\ChoferController;
use App\Http\Controllers\AyudanteController;
use App\Http\Controllers\ProfileController;

Route::redirect('/', '/login');

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth','role:supervisor'])->group(function(){
    Route::get('/supervisor', [SupervisorController::class, 'index'])->name('supervisor.dashboard');
});

Route::middleware(['auth','role:cajero'])->group(function(){
    Route::get('/cajero', [CajeroController::class, 'index'])->name('cajero.dashboard');
});

Route::middleware(['auth','role:chofer'])->group(function(){
    Route::get('/chofer', [ChoferController::class, 'index'])->name('chofer.dashboard');
});

Route::middleware(['auth','role:ayudante'])->group(function(){
    Route::get('/ayudante', [AyudanteController::class, 'index'])->name('ayudante.dashboard');
});

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
