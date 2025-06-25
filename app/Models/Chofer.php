<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{
    use HasFactory;
    protected $table = 'choferes';
    protected $fillable = [
        'numero',
        'bus_codigo',
        'nombre_chofer',
        'licencia',
        'vencimiento_licencia',
    ];
    protected $casts = [
        'vencimiento_licencia' => 'date',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
