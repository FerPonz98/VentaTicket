<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chofer;

class Kardex extends Model
{
    use HasFactory;

    protected $table = 'kardex';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'chofer_ci',
        'producto_nombre',
    ];

    protected $appends = [
        'CI',
        'nombre_chofer',
        'licencia',
        'vencimiento_licencia',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function chofer()
    {
        return $this->belongsTo(Chofer::class, 'chofer_ci', 'CI');
    }

    public function getCIAttribute()
    {
        return optional($this->chofer)->CI;
    }

    public function getNombreChoferAttribute()
    {
        return optional($this->chofer)->nombre_chofer;
    }

    public function getLicenciaAttribute()
    {
        return optional($this->chofer)->licencia;
    }

    public function getVencimientoLicenciaAttribute()
    {
        return optional($this->chofer)->vencimiento_licencia;
    }
}
