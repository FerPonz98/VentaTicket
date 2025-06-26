<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Cada noche, bloquea a los usuarios (no admin) creados hace 80+ días
        $schedule->call(function () {
            User::where('rol', '!=', 'admin')
                ->where('estado', '!=', 'bloqueado')
                ->where('created_at', '<=', now()->subDays(80))
                ->update(['estado' => 'bloqueado']);
        })->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
