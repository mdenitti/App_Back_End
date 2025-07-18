<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftResource\Pages;
use App\Filament\Resources\ShiftResource\RelationManagers;
use App\Models\Shift;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
           ->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->label('Arbeider')
                ->required(),

            Forms\Components\Select::make('project_id')
                ->relationship('project', 'name')
                ->label('Project')
                ->required(),

            Forms\Components\DatePicker::make('shift_date')
                ->label('Datum')
                ->required(),

            Forms\Components\TimePicker::make('planned_start')
                ->label('Startuur')
                ->required(),

            Forms\Components\TimePicker::make('planned_end')
                ->label('Einduur')
                ->required(),

            Forms\Components\TextInput::make('planned_break')
                ->label('Pauze (minuten)')
                ->numeric()
                ->required(),
           ])
            ->columns(2)
            ->statePath('data');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Arbeiders')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shift_date'),
                Tables\Columns\TextColumn::make('planned_start'),
                Tables\Columns\TextColumn::make('planned_end'),
                Tables\Columns\TextColumn::make('planned_break')
                    ->label('Pauze (min)'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShifts::route('/'),
            'create' => Pages\CreateShift::route('/create'),
            'edit' => Pages\EditShift::route('/{record}/edit'),
        ];
    }
}
