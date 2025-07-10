<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteCsvController extends Controller
{
    public function form()
    {
        return view('docente.subir_csv');
    }

    public function verEstudiantes()
    {
        $usuario = auth()->user();

        $estudiantes = Estudiante::with('notas')
            ->where('grado_id', $usuario->grado_id)
            ->where('seccion_id', $usuario->seccion_id)
            ->get();

        return view('docente.lista_estudiantes', compact('estudiantes', 'usuario'));
    }

    public function importar(Request $request)
    {
        $request->validate([
            'archivo_csv' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('archivo_csv');
        $handle = fopen($file->getRealPath(), 'r');

        // Leer encabezado de cursos
        $header = fgetcsv($handle, 1000, ';');

        $usuario = Auth::user();
        $grado_id = $usuario->grado_id;
        $seccion_id = $usuario->seccion_id;

        // Seguridad: verificar que el docente tiene grado y sección asignados
        if (!$grado_id || !$seccion_id) {
            return back()->with('error', 'Tu cuenta no tiene un grado y sección asignados.');
        }

        while (($data = fgetcsv($handle, 1000, ';')) !== false) {
            if (count($data) < 3 || strtolower(trim($data[0])) == 'nombres apellidos') {
                continue;
            }

            $nombre = trim($data[0]) . ' ' . trim($data[1]);
            $sexo = strtolower(trim($data[2]));

            if (!in_array($sexo, ['f', 'm'])) {
                continue;
            }

            // Verificar duplicados
            $existe = Estudiante::where('nombres_completos', $nombre)
                ->where('grado_id', $grado_id)
                ->where('seccion_id', $seccion_id)
                ->exists();

           if (!$existe) {
    $estudiante = Estudiante::create([
        'nombres_completos' => $nombre,
    'sexo' => $sexo,
    'grado_id' => $grado_id,
    'seccion_id' => $seccion_id,
    'usuario_id' => $usuario->id, // 👈 FIX aplicado aquí
    ]);

    $anioIndex = array_search('anio', array_map('strtolower', $header));
    $anio = ($anioIndex !== false && isset($data[$anioIndex])) ? intval($data[$anioIndex]) : now()->year;

    for ($i = 3; $i < count($data); $i++) {
        $curso = $header[$i] ?? null;
        $nota = $data[$i];

        if (strtolower(trim($curso)) === 'anio') {
            continue;
        }

        if ($curso && $nota !== '') {
            Nota::create([
                'estudiante_id' => $estudiante->id,
                'curso' => $curso,
                'valor' => $nota,
                'anio' => $anio,
            ]);
        }
    }
}
        }

        fclose($handle);

        return redirect()->route('docente.csv.form')->with('success', 'Archivo CSV importado correctamente.');
    }
    public function eliminarEstudiantes()
{
    $user = auth()->user();

    Estudiante::where('grado_id', $user->grado_id)
        ->where('seccion_id', $user->seccion_id)
        ->delete();

    return back()->with('success', 'Todos los estudiantes han sido eliminados.');
}

}
