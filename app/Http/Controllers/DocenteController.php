<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Estudiante;
use App\Models\Nota;
use App\Models\DocenteGradoSeccion;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
    public function panel()
{
    $user= auth()->user(); // Docente logueado

    // Obtener su asignación (grado y sección)
    $asignacion = DocenteGradoSeccion::where('usuario_id', $user->id)->first();

    $estudiantes = collect(); // Colección vacía por defecto

    if ($asignacion) {
        $estudiantes = Estudiante::with('notas')
            ->where('grado_id', $asignacion->grado_id)
            ->where('seccion_id', $asignacion->seccion_id)
            ->where('usuario_id', $user->id)
            ->get();
    }

    return view('dashboard.docente', compact('user', 'estudiantes'));
}
}