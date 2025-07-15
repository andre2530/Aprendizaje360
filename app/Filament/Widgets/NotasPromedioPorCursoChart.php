<?php

namespace App\Filament\Widgets;

use App\Models\Nota;
use Filament\Widgets\ChartWidget;

class NotasPromedioPorCursoChart extends ChartWidget
{
    protected static ?string $heading = 'Promedio de Calificaciones por Curso';
    protected static ?string $maxHeight = '300px'; // Igual que NotasPorCategoriaChart
   

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

        // Paleta igual a CantidadEstudiantesPorCursoBarChart
        $baseColors = [
            '#2563eb', '#06b6d4', '#a21caf', '#f59e42', '#f43f5e', '#22d3ee', '#fbbf24', '#64748b'
        ];
        $borderColors = [];
        $backgroundColors = [];
        $paletteCount = count($baseColors);
        foreach (array_keys($labels) as $i) {
            $borderColors[] = $baseColors[$i % $paletteCount];
            $backgroundColors[] = $baseColors[$i % $paletteCount] . '22'; // translúcido
        }

        return [
            'datasets' => [
                [
                    'label' => 'Promedio',
                    'data' => $notas->values(),
                    'borderColor' => $borderColors,
                    'backgroundColor' => $backgroundColors,
                    'borderWidth' => 2.5,
                    'pointBackgroundColor' => $borderColors,
                    'pointBorderColor' => '#fff',
                    'pointRadius' => 5,
                    'pointHoverRadius' => 7,
                    'fill' => false,
                    'tension' => 0.45,
                ],
            ],
            'labels' => $labels,
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'legend' => [
                        'display' => false,
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'backgroundColor' => '#fff',
                        'titleColor' => '#0f172a',
                        'bodyColor' => '#334155',
                        'borderColor' => '#e0e7ef',
                        'borderWidth' => 1,
                        'callbacks' => [
                            'label' => 'function(context) { return `Promedio: ${context.parsed.y.toFixed(2)}`; }',
                        ],
                        'displayColors' => true,
                        'padding' => 16,
                        'caretSize' => 8,
                        'cornerRadius' => 10,
                        'titleFont' => [
                            'weight' => 'bold',
                            'size' => 18,
                        ],
                        'bodyFont' => [
                            'size' => 17,
                        ],
                    ],
                ],
                'animation' => [
                    'duration' => 1200,
                    'easing' => 'easeOutCubic',
                ],
                'layout' => [
                    'padding' => 24,
                ],
                'scales' => [
                    'x' => [
                        'grid' => [
                            'color' => '#f1f5f9',
                            'drawBorder' => false,
                        ],
                        'ticks' => [
                            'color' => '#0f172a',
                            'font' => [
                                'size' => 16,
                                'weight' => 'bold',
                            ],
                            'padding' => 8,
                        ],
                        'title' => [
                            'display' => true,
                            'text' => 'Curso',
                            'color' => '#334155',
                            'font' => [
                                'size' => 16,
                                'weight' => 'bold',
                            ],
                        ],
                    ],
                    'y' => [
                        'beginAtZero' => true,
                        'grid' => [
                            'color' => '#f1f5f9',
                        ],
                        'ticks' => [
                            'color' => '#334155',
                            'font' => [
                                'size' => 15,
                                'weight' => 'bold',
                            ],
                            'padding' => 8,
                        ],
                        'title' => [
                            'display' => true,
                            'text' => 'Promedio',
                            'color' => '#334155',
                            'font' => [
                                'size' => 16,
                                'weight' => 'bold',
                            ],
                        ],
                    ],
                ],
                'accessibility' => [
                    'enabled' => true,
                    'description' => 'Gráfico de barras de promedios por curso',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}