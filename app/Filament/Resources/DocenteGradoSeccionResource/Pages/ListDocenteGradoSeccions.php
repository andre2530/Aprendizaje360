<?php

namespace App\Filament\Resources\DocenteGradoSeccionResource\Pages;

use App\Filament\Resources\DocenteGradoSeccionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocenteGradoSeccions extends ListRecords
{
    protected static string $resource = DocenteGradoSeccionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
