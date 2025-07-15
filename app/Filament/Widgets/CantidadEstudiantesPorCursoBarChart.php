<?php

namespace App\Filament\Widgets;

use App\Models\Nota;
use Filament\Widgets\ChartWidget;

class CantidadEstudiantesPorCursoBarChart extends ChartWidget
{
    protected static ?string $heading = 'Cantidad de Estudiantes por Curso (Barras)';
    protected static ?string $maxHeight = '600px';
    protected static ?string $extraAttributes = 'class=w-full style=width:100vw;min-width:100vw;';

    protected function getData(): array
    {
        $data = Nota::selectRaw('curso, COUNT(DISTINCT estudiante_id) as cantidad')
            ->groupBy('curso')
            ->orderByDesc('cantidad')
            ->pluck('cantidad', 'curso');

        $labels = $data->keys()->values()->all();

        $backgroundColors = [
            '#2563eb', '#06b6d4', '#a21caf', '#f59e42', '#f43f5e', '#22d3ee', '#fbbf24', '#64748b'
        ];
        $colors = [];
        $paletteCount = count($backgroundColors);
        foreach (array_keys($labels) as $i) {
            $colors[] = $backgroundColors[$i % $paletteCount];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Estudiantes',
                    'data' => $data->values(),
                    'borderColor' => '#2563eb',
                    'backgroundColor' => 'rgba(37,99,235,0.12)',
                    'borderWidth' => 2.5,
                    'pointBackgroundColor' => '#2563eb',
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
                            'label' => 'function(context) { return `Estudiantes: ${context.parsed.y}`; }',
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
                            'text' => 'Cantidad de Estudiantes',
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
                    'description' => 'Gráfico de líneas con puntos de cantidad de estudiantes por curso',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Gráfico de líneas con puntos
    }
}
