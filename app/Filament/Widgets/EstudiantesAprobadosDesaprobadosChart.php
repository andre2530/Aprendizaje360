<?php

namespace App\Filament\Widgets;

use App\Models\Nota;
use Filament\Widgets\ChartWidget;

class EstudiantesAprobadosDesaprobadosChart extends ChartWidget
{
    protected static ?string $heading = 'Estudiantes Aprobados vs Desaprobados';
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        // Se asume que A y B son aprobados, C y otros son desaprobados
        $aprobados = Nota::whereIn('valor', ['A', 'B'])->distinct('estudiante_id')->count('estudiante_id');
        $desaprobados = Nota::whereNotIn('valor', ['A', 'B'])->distinct('estudiante_id')->count('estudiante_id');

        $labels = ['Aprobados', 'Desaprobados'];
        $data = [$aprobados, $desaprobados];
        // Colores sólidos, suaves y minimalistas
        $backgroundColors = ['#38bdf8', '#f87171']; // azul claro y rojo claro
        $borderColors = ['#0ea5e9', '#ef4444']; // azul y rojo

        return [
            'datasets' => [
                [
                    'label' => 'Estudiantes',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 1.5,
                    'borderRadius' => 6,
                    'barPercentage' => 0.5,
                    'categoryPercentage' => 0.4,
                    'datalabels' => [
                        'display' => true,
                        'color' => '#1e293b',
                        'font' => [
                            'weight' => '600',
                            'size' => 15,
                            'family' => 'Inter, Segoe UI, Arial, sans-serif',
                        ],
                        'anchor' => 'end',
                        'align' => 'end',
                        'formatter' => 'function(value) { return value.toLocaleString(); }',
                    ],
                ],
            ],
            'labels' => $labels,
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                        'labels' => [
                            'color' => '#334155',
                            'font' => [
                                'size' => 14,
                                'weight' => '600',
                                'family' => 'Inter, Segoe UI, Arial, sans-serif',
                            ],
                            'usePointStyle' => true,
                            'padding' => 10,
                        ],
                    ],
                    'tooltip' => [
                        'enabled' => true,
                        'backgroundColor' => '#fff',
                        'titleColor' => '#0f172a',
                        'bodyColor' => '#334155',
                        'borderColor' => '#e0e7ef',
                        'borderWidth' => 1,
                        'callbacks' => [
                            'label' => 'function(context) { return `${context.label}: ${context.parsed.y.toLocaleString()}`; }',
                        ],
                        'displayColors' => false,
                        'padding' => 10,
                        'caretSize' => 6,
                        'cornerRadius' => 6,
                        'titleFont' => [
                            'weight' => '600',
                            'size' => 15,
                        ],
                        'bodyFont' => [
                            'size' => 14,
                        ],
                    ],
                    'datalabels' => [
                        'display' => true,
                        'color' => '#1e293b',
                        'font' => [
                            'weight' => '600',
                            'size' => 15,
                            'family' => 'Inter, Segoe UI, Arial, sans-serif',
                        ],
                        'anchor' => 'end',
                        'align' => 'end',
                        'formatter' => 'function(value) { return value.toLocaleString(); }',
                    ],
                ],
                'animation' => [
                    'duration' => 900,
                    'easing' => 'easeOutCubic',
                ],
                'layout' => [
                    'padding' => 12,
                ],
                'scales' => [
                    'x' => [
                        'grid' => [
                            'display' => false,
                        ],
                        'ticks' => [
                            'color' => '#1e293b',
                            'font' => [
                                'size' => 13,
                                'weight' => '600',
                                'family' => 'Inter, Segoe UI, Arial, sans-serif',
                            ],
                            'padding' => 6,
                        ],
                        'title' => [
                            'display' => false,
                        ],
                    ],
                    'y' => [
                        'beginAtZero' => true,
                        'grid' => [
                            'color' => '#f3f4f6',
                        ],
                        'ticks' => [
                            'color' => '#64748b',
                            'font' => [
                                'size' => 13,
                                'weight' => '600',
                                'family' => 'Inter, Segoe UI, Arial, sans-serif',
                            ],
                            'padding' => 6,
                        ],
                        'title' => [
                            'display' => false,
                        ],
                    ],
                ],
                'accessibility' => [
                    'enabled' => true,
                    'description' => 'Gráfico minimalista de estudiantes aprobados y desaprobados',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Gráfico de barras
    }
}
