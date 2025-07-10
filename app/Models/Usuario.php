<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios'; // clave para que use esta tabla

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function gradosSecciones()
{
   return $this->belongsToMany(
            Grado::class,                 // modelo relacionado
            'docente_grado_seccion',     // tabla pivot
            'usuario_id',                // clave foránea del modelo actual (Usuario)
            'grado_id'                   // clave foránea del modelo relacionado (Grado)
)
        ->withPivot('seccion_id')->withTimestamps();
        
    }
}
