<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    
    protected $fillable = ['nombre'];

    public function docentes()
    {
        return $this->belongsToMany(Usuario::class, 'docente_grado_seccion')
                    ->withPivot('seccion_id')
                    ->withTimestamps();
    }
}
