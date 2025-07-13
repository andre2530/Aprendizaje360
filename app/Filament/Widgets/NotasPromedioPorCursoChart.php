<?php

namespace App\Filament\Widgets;

use App\Models\Nota;
use Filament\Widgets\ChartWidget;

class NotasPromedioPorCursoChart extends ChartWidget
{
    protected static ?string $heading = 'Promedio de Calificaciones por Curso';

    protected function getData(): array
    {
        $notas = Nota::selectRaw('curso, AVG(CASE valor
            WHEN "A" THEN 20
            WHEN "B" THEN 15
            WHEN "C" THEN 10
            ELSE 0 END) as promedio')
            ->groupBy('curso')
            ->orderByDesc('promedio')
            ->pluck('promedio', 'curso');

        $labels = $notas->keys()->values()->all();

        // Genera un color diferente para cada curso
        $colors = [];
        foreach ($labels as $label) {
            $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Promedio de calificación',
                    'data' => $notas->values(),
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}