<?php

namespace App\Filament\Resources;

use App\Enums\Support;
use App\Filament\Resources\MaxPriceResource\Pages;
use App\Models\MaxPrice;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class MaxPriceResource extends Resource
{
    protected static ?string $model = MaxPrice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('created_at')
                    ->visibleOn('view'),
                DateTimePicker::make('updated_at')
                    ->visibleOn('view'),
                TextInput::make('item')
                    ->required()
                    ->regex('/[0-1][0-9]_\d{3}_\d{4}_\d_\d/'),
                TextInput::make('price')
                    ->required()
                    ->regex('/^\d+(?:\.\d{1,2})?$/'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item')
                    ->label('Item (Support Category)')
                    ->formatStateUsing(
                        function ($state) {
                            $first = explode('_', $state)[0];
                            $as_assoc = array_column(Support::cases(), 'name', 'value');
                            $with_space = preg_replace('/(.)([A-Z])/', '$1 $2', $as_assoc[$first]);

                            return "$state ($with_space)";
                        }
                    ),
                TextColumn::make('price')
                    ->formatStateUsing(fn ($state) => '$'.$state),
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
            'index' => Pages\ListMaxPrices::route('/'),
            'create' => Pages\CreateMaxPrice::route('/create'),
            'view' => Pages\ViewMaxPrice::route('/{record}'),
            'edit' => Pages\EditMaxPrice::route('/{record}/edit'),
        ];
    }
}
