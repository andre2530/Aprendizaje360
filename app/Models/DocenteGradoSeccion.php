<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Usuarior;
use App\Models\Grado;
use App\Models\Seccion;

class DocenteGradoSeccion extends Model
{
    use HasFactory;

    protected $table = 'docente_grado_seccion';

    protected $fillable = [
        'usuario_id',
        'grado_id',
        'seccion_id',
    ];

    public function docente()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
}
