<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocenteGradoSeccionResource\Pages;
use App\Models\DocenteGradoSeccion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use App\Models\Usuario;
use App\Models\Grado;
use App\Models\Seccion;

class DocenteGradoSeccionResource extends Resource
{
    protected static ?string $model = DocenteGradoSeccion::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Asignar Docentes';
    protected static ?string $pluralModelLabel = 'Asignaciones';
    protected static ?string $modelLabel = 'Asignación';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('usuario_id')
    ->label('Docente')
    ->options(
        \App\Models\Usuario::where('rol', 'docente')
            ->pluck('name', 'id')
    )
    ->searchable()
    ->required(),

                Forms\Components\Select::make('grado_id')
                    ->label('Grado')
                    ->relationship('grado', 'nombre') // 'nombre' debe existir en el modelo Grado
                    ->required(),

                Forms\Components\Select::make('seccion_id')
                    ->label('Sección')
                    ->relationship('seccion', 'nombre') // 'nombre' debe existir en el modelo Seccion
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('docente.name')
                    ->label('Docente')
                    ->searchable(),

                Tables\Columns\TextColumn::make('grado.nombre')
                    ->label('Grado'),

                Tables\Columns\TextColumn::make('seccion.nombre')
                    ->label('Sección'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocenteGradoSeccions::route('/'),
            'create' => Pages\CreateDocenteGradoSeccion::route('/create'),
            'edit' => Pages\EditDocenteGradoSeccion::route('/{record}/edit'),
        ];
    }
}
