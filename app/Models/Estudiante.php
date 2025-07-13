<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $fillable = [
        'nombres_completos',
        'sexo',
        'grado_id',
        'seccion_id',
        'usuario_id', 
    ];

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }
}
