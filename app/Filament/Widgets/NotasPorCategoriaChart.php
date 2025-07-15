<?php

namespace App\Filament\Widgets;

use App\Models\Nota;
use Filament\Widgets\ChartWidget;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class NotasPorCategoriaChart extends ChartWidget
{
    use InteractsWithForms;

    protected static ?string $heading = 'Distribución de Notas';
    protected static ?string $maxHeight = '253px'; // Un poco más alto para mejor visualización
    

    public ?string $anio = null;

    protected function getFormSchema(): array
    {
        $anios = Nota::select('anio')
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio', 'anio');

        return [
            Select::make('anio')
                ->label('Año')
                ->options($anios)
                ->searchable()
                ->native(false)
                ->reactive()
                ->afterStateUpdated(fn () => $this->updateChartData()),
        ];
    }

    protected function getData(): array
    {
        $user = auth()->user();
        $query = Nota::whereHas('estudiante', function ($q) use ($user) {
            $q->where('usuario_id', $user->id);
        });
        if ($this->anio) {
            $query->where('anio', $this->anio);
        }
        $notas = $query->selectRaw('valor, COUNT(*) as total')
            ->groupBy('valor')
            ->orderBy('valor')
            ->pluck('total', 'valor');

        // Paleta igual a CantidadEstudiantesPorCursoBarChart pero translúcida
        $baseColors = [
            '#2563eb', '#06b6d4', '#a21caf', '#f59e42', '#f43f5e', '#22d3ee', '#fbbf24', '#64748b'
        ];
        $backgroundColors = [];
        $hoverOffset = [];
        $paletteCount = count($baseColors);
        $labels = $notas->keys();
        $maxIndex = $notas->values()->search($notas->max());
        foreach (array_keys($labels->all()) as $i) {
            $backgroundColors[] = $baseColors[$i % $paletteCount] . 'cc';
            $hoverOffset[] = ($i === $maxIndex) ? 18 : 10;
        }
        $total = $notas->sum();

        return [
            'datasets' => [
                [
                    'label' => 'Notas',
                    'data' => $notas->values(),
                    'backgroundColor' => $backgroundColors,
                    'hoverOffset' => $hoverOffset,
                    'borderWidth' => 3,
                    'borderColor' => '#fff',
                    'datalabels' => [
                        'display' => true,
                        'color' => '#1e293b',
                        'font' => [
                            'weight' => 'bold',
                            'size' => 22,
                            'family' => 'Inter, Segoe UI, Arial, sans-serif',
                        ],
                        'formatter' => "function(value, context) { if (context.dataIndex === 0) { return 'Total: $total'; } return ''; }",
                        'align' => 'center',
                        'anchor' => 'center',
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
                            'color' => '#1e293b',
                            'font' => [
                                'size' => 16,
                                'weight' => 'bold',
                                'family' => 'Inter, Segoe UI, Arial, sans-serif',
                            ],
                            'usePointStyle' => true,
                            'padding' => 20,
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
                            'label' => 'function(context) { return `${context.label}: ${context.parsed}`; }',
                        ],
                        'displayColors' => true,
                        'padding' => 18,
                        'caretSize' => 8,
                        'cornerRadius' => 12,
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
                    'padding' => 32,
                ],
                'cutout' => '0%',
                'backgroundColor' => 'transparent',
                'accessibility' => [
                    'enabled' => true,
                    'description' => 'Gráfico de torta de distribución de notas',
                ],
                // Eliminar cualquier grid/líneas de fondo
                'scales' => [],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}