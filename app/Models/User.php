<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuarios';

    protected $primaryKey = 'ci_usuario';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'foto',
        'nombre_usuario',
        'apellidos',
        'ci_usuario',
        'sexo',
        'fecha_nacimiento',
        'estado',
        'estado_civil',
        'lugar_residencia',
        'domicilio',
        'email',
        'celular',
        'referencias',
        'rol',
        'documento_1',
        'documento_2',
        'documento_3',
        'documento_4',
        'documento_5',
        'creado_en',
        'password' ,
        'security_question',
        'security_answer',
        'sucursal'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function chofer()
    {
        return $this->hasOne(Chofer::class, 'CI', 'ci_usuario');
    }

}


