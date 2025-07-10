<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = [
        'estudiante_id',
        'curso',
        'valor',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
