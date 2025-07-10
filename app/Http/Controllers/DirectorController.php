<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\Seccion;
use App\Models\Usuario;

class DirectorController extends Controller
{
    public function index(Request $request)
    {
        $grados = Grado::all();
        $secciones = Seccion::all();
        $docentes = Usuario::where('rol', 'docente')->get();

        $query = Estudiante::with(['notas', 'grado', 'seccion']);

        if ($request->filled('grado')) {
            $query->where('grado_id', $request->grado);
        }

        if ($request->filled('seccion')) {
            $query->where('seccion_id', $request->seccion);
        }

        if ($request->filled('docente')) {
            $query->where('usuario_id', $request->docente);
        }

        if ($request->filled('anio')) {
            $query->where('anio', $request->anio);
        }

        $estudiantes = $query->get();

        return view('dashboard.director', compact('grados', 'secciones', 'docentes', 'estudiantes'));
    }
}