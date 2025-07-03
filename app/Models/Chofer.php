<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bus;
use App\Models\User;

class Chofer extends Model
{
    use HasFactory;

    protected $table = 'choferes';
    protected $primaryKey = 'CI';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'CI',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'CI', 'ci_usuario');
    }
    public function kardexes()
    {
        return $this->hasMany(Kardex::class, 'chofer_id', 'CI');
    }
    public function chofer()
    {
        return $this->belongsTo(Chofer::class, 'chofer_id', 'CI');
    }
}
