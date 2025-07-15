<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Grado;
use App\Models\Seccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
   public function index()
{
    $docentes = Usuario::where('rol', 'docente')->get();
    $grados = Grado::all();
    $secciones = Seccion::all();

    return view('asignacion.index', compact('docentes', 'grados', 'secciones'));
}

public function store(Request $request)
{
    $request->validate([
        'usuario_id' => 'required|exists:usuarios,id',
        'grado_id' => 'required|exists:grados,id',
        'seccion_id' => 'required|exists:secciones,id',
        'anio' => 'required|integer', // 👈 Añade validación para el año
    ]);

    DB::table('docente_grado_seccion')->updateOrInsert(
        ['usuario_id' => $request->usuario_id],
        [
            'grado_id' => $request->grado_id,
            'seccion_id' => $request->seccion_id,
            'anio' => $request->anio, // 👈 Guarda el año del CSV
        ]
    );

    return redirect()->route('asignar.index')->with('success', 'Asignación guardada.');
}
}
