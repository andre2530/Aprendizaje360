<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Nota;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function generarPdf()
    {
        $docente = Auth::user();

        $estudiantes = Estudiante::where('grado_id', $docente->grado_id)
            ->where('seccion_id', $docente->seccion_id)
            ->with('notas')
            ->get();

        $totalNotas = Nota::whereHas('estudiante', function ($q) use ($docente) {
            $q->where('grado_id', $docente->grado_id)
              ->where('seccion_id', $docente->seccion_id);
        })->count();

        $conteo = Nota::whereHas('estudiante', function ($q) use ($docente) {
            $q->where('grado_id', $docente->grado_id)
              ->where('seccion_id', $docente->seccion_id);
        })->selectRaw('valor, COUNT(*) as total')
          ->groupBy('valor')
          ->pluck('total', 'valor');

        $porcentajes = $conteo->map(function ($total, $valor) use ($totalNotas) {
            return round(($total / $totalNotas) * 100, 2);
        });

        $pdf = Pdf::loadView('reportes.reporte-notas', [
            'docente' => $docente,
            'estudiantes' => $estudiantes,
            'conteo' => $conteo,
            'porcentajes' => $porcentajes,
            'totalNotas' => $totalNotas,
            'fecha' => now()->format('d/m/Y H:i')
        ]);

        return $pdf->download('reporte_dashboard.pdf');
    }
     public function generarPdfDirector()
{
    $reporte = [];

    $docentes = \App\Models\Usuario::where('rol', 'docente')->get();

    foreach ($docentes as $docente) {
        $estudiantes = \App\Models\Estudiante::where('usuario_id', $docente->id)
            ->with(['notas', 'grado', 'seccion'])
            ->get();

        $reporte[$docente->id] = [
            'docente' => $docente->name,
            'estudiantes' => $estudiantes
        ];
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reportes.director', [
        'reporte' => $reporte,
        'fecha' => now()->format('d/m/Y H:i'),
    ]);

    return $pdf->download('reporte_general_por_docente.pdf');
}
}