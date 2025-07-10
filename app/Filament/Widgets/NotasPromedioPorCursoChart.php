<?php

namespace App\Filament\Widgets;

use App\Models\Nota;
use Filament\Widgets\ChartWidget;

class NotasPromedioPorCursoChart extends ChartWidget
{
    protected static ?string $heading = 'Promedio de Notas por Curso';

    protected function getData(): array
    {
        $notas = Nota::selectRaw('curso, AVG(CASE valor
            WHEN "A" THEN 20
            WHEN "B" THEN 15
            WHEN "C" THEN 10
            ELSE 0 END) as promedio')
            ->groupBy('curso')
            ->pluck('promedio', 'curso');

        return [
            'datasets' => [
                [
                    'label' => 'Promedio',
                    'data' => $notas->values(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#93c5fd',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $notas->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
