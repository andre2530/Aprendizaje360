<?php

namespace App\Filament\Resources\DocenteGradoSeccionResource\Pages;

use App\Filament\Resources\DocenteGradoSeccionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocenteGradoSeccion extends EditRecord
{
    protected static string $resource = DocenteGradoSeccionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
