<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\Turno;
use App\Policies\TurnoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Turno::class => TurnoPolicy::class,  // Registra la política para el modelo Turno
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
