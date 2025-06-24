<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chofer extends Model
{
    use HasFactory;
    protected $table = 'choferes';
    protected $fillable = [
        'bus_id',
        'nombre_chofer',
        'licencia',
        'licencia_vencimiento',
        'nombre_ayudante',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
