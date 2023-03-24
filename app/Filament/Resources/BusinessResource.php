<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Models\Business;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('created_at')
                    ->visibleOn('view'),
                DateTimePicker::make('updated_at')
                    ->visibleOn('view'),
                TextInput::make('abn')
                    ->label('ABN Number')
                    ->unique(ignoreRecord: true)
                    ->integer()
                    ->length(11),
                TextInput::make('name'),
                TextInput::make('xero_key')
                    ->maxLength(255),
                Select::make('createdBy.name')
                    ->relationship('createdBy', 'name')
                    ->visibleOn('view'),
                DateTimePicker::make('verified_at')
                    ->visibleOn('view'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('abn')
                    ->label('ABN Number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('createdBy.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('verified_at')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ?? 'Not Verified'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'view' => Pages\ViewBusiness::route('/{record}'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
