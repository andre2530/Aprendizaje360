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
    protected static ?string $maxHeight = '300px';

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
        $user = auth()->user(); // CORRECTO: obtener el usuario logueado

        $query = Nota::whereHas('estudiante', function ($q) use ($user) {
            $q->where('usuario_id', $user->id); // CORREGIDO: antes decía $usuario
        });

        if ($this->anio) {
            $query->where('anio', $this->anio);
        }

        $notas = $query->selectRaw('valor, COUNT(*) as total')
            ->groupBy('valor')
            ->orderBy('valor')
            ->pluck('total', 'valor');

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad',
                    'data' => $notas->values(),
                    'backgroundColor' => ['#f87171', '#60a5fa', '#34d399', '#fbbf24'],
                ],
            ],
            'labels' => $notas->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}