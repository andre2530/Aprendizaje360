<?php

namespace App\Filament\Pages;

use App\Models\Nota;
use App\Models\Estudiante;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Widgets\NotasPorCategoriaChart;
use App\Filament\Widgets\NotasPromedioPorCursoChart;
use App\Filament\Widgets\CantidadEstudiantesPorCursoBarChart;
use App\Filament\Widgets\EstudiantesAprobadosDesaprobadosChart;

class DashboardDocente extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Docente';
    protected static ?string $title = 'Dashboard';
    protected static string $view = 'filament.pages.dashboard-docente';

    // Datos que enviaremos a la vista
    public $estudiantes;

    public function mount(): void
    {
        $user = auth()->user();
        $this->estudiantes = collect(); 

        $asignaciones = $user->gradosSecciones;

        foreach ($asignaciones as $asignacion) {
            $gradoId = $asignacion->id;
            $seccionId = $asignacion->pivot->seccion_id;

            $grupo = Estudiante::where('grado_id', $gradoId)
                ->where('seccion_id', $seccionId)
                ->with('notas')
                ->get();

            $this->estudiantes = $this->estudiantes->merge($grupo);
        }
    }

    protected function getHeaderWidgets(): array
    {
        return [
            NotasPorCategoriaChart::class,
            NotasPromedioPorCursoChart::class,
            CantidadEstudiantesPorCursoBarChart::class,
            EstudiantesAprobadosDesaprobadosChart::class,
        ];
    }

    public function getTableQuery()
    {
        return Nota::with('estudiante')->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('estudiante.nombres_completos')->label('Estudiante'),
            TextColumn::make('curso')->label('Curso'),
            TextColumn::make('valor')->label('Nota'),
        ];
    }
}