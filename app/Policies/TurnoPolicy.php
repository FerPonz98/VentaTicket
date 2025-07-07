<?php

// app/Policies/TurnoPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Turno;

class TurnoPolicy
{
    /**
     * Determina si el usuario puede ver el turno.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Turno  $turno
     * @return bool
     */
    public function view(User $user, Turno $turno)
    {

        if ($user->rol === 'admin') {
            return true;
        }

        if ($user->rol === 'Supervisor Gral') {
            return true;
        }

        if ($user->rol === 'Supervisor SUC' && $user->sucursal === $turno->sucursal_id) {
            return true;
        }

        if ($user->rol === 'cajero' && $user->ci_usuario === $turno->ci_usuario) {
            return true;
        }

        if (in_array($user->rol, ['Ventas QR', 'Carga', 'Encomienda']) && $user->ci_usuario === $turno->ci_usuario) {
            return true;
        }

        return false;
    }

    /**
     * Determina si el usuario puede actualizar o cerrar el turno.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Turno  $turno
     * @return bool
     */
    public function update(User $user, Turno $turno)
    {
        if ($user->rol === 'admin') {
            return true;
        }

        if ($user->rol === 'Supervisor Gral') {
            return true;
        }

        if ($user->rol === 'Supervisor SUC' && $user->sucursal === $turno->sucursal_id) {
            return true;
        }

        if ($user->rol === 'cajero' && $user->ci_usuario === $turno->ci_usuario) {
            return true;
        }

        return false;
    }

    /**
     * Determina si el usuario puede crear el turno.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Turno  $turno
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->rol === 'admin') {
            return true;
        }
        if ($user->rol === 'Supervisor Gral') {
            return true;
        }

        if ($user->rol === 'Supervisor SUC') {
            return true;
        }

        if (in_array($user->rol, ['cajero', 'Ventas QR', 'Carga', 'Encomienda'])) {
            return true;
        }

        return false;
    }

    /**
     * Determina si el usuario puede registrar un ingreso o egreso en un turno.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Turno  $turno
     * @return bool
     */
    public function registerMovement(User $user, Turno $turno)
    {
        if (in_array($user->rol, ['admin', 'Supervisor Gral', 'Supervisor SUC'])) {
            return true;
        }

        if ($user->rol === 'cajero' && $user->ci_usuario === $turno->ci_usuario) {
            return true;
        }

        if (in_array($user->rol, ['Ventas QR', 'Carga', 'Encomienda']) && $user->ci_usuario === $turno->ci_usuario) {
            return true;
        }

        return false;
    }
}


