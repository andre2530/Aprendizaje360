<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocenteGradoSeccionResource\Pages;
use App\Models\DocenteGradoSeccion;
use App\Models\Usuario;
use App\Models\Grado;
use App\Models\Seccion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocenteGradoSeccionResource extends Resource
{
    protected static ?string $model = DocenteGradoSeccion::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Asignar Docentes';
    protected static ?string $pluralModelLabel = 'Asignaciones';
    protected static ?string $modelLabel = 'Asignación';

    public static function canViewAny(): bool
{
    return auth()->check() && auth()->user()->email === 'admin@gmail.com';
}


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('usuario_id')
                ->label('Docente')
                ->options(Usuario::where('rol', 'docente')->pluck('name', 'id')->toArray())
                ->searchable()
                ->required(),

            Forms\Components\Select::make('grado_id')
                ->label('Grado')
                ->relationship('grado', 'nombre')
                ->required(),

            Forms\Components\Select::make('seccion_id')
                ->label('Sección')
                ->relationship('seccion', 'nombre')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('usuario.name') // ← relación correcta
                    ->label('Docente')
                    ->searchable(),

                Tables\Columns\TextColumn::make('grado.nombre')
                    ->label('Grado'),

                Tables\Columns\TextColumn::make('seccion.nombre')
                    ->label('Sección'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('y/m/d H:i'),
            ])
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