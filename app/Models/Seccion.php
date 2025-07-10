<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $fillable = ['nombre'];

    public function docentes()
    {
        return $this->belongsToMany(Usuario::class, 'docente_grado_seccion')
                    ->withPivot('grado_id')
                    ->withTimestamps();
    }
    protected $table = 'secciones';
}
