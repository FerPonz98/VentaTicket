<?php

// app/Models/Turno.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = ['cajero_id','fecha_inicio','fecha_fin','total_pagado'];

    public function cajero()
    {
        return $this->belongsTo(User::class, 'cajero_id','ci_usuario');
    }

    public function cargas()
    {
        return $this->hasMany(Carga::class);
    }
}
