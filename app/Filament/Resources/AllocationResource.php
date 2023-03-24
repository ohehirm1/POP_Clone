<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllocationResource\Pages;
use App\Models\Allocation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use FilamentAddons\Forms\Components\Separator;
use FilamentAddons\Forms\Components\Timestamps;

class AllocationResource extends Resource
{
    protected static ?string $model = Allocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(['default' => 1])->schema([
                    Placeholder::make('id')->label('Internal ID')
                        ->content(fn ($record) => $record->id),
                ]),

                Grid::make(['default' => 1])->schema([
                    Separator::make(),
                ]),

                TextInput::make('support_item'),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                TextInput::make('price_charged'),
                TextInput::make('allocated_amount'),
                TextInput::make('advance_amount'),
                DateTimePicker::make('verified_at')
                    ->visibleOn('view'),
                DateTimePicker::make('participant_verified_at')
                    ->visibleOn('view'),
                Select::make('createdBy.name')
                    ->relationship('createdBy', 'name')
                    ->visibleOn('view'),

                Grid::make(['default' => 1])->schema([
                    Separator::make(),
                ]),

                Grid::make()->schema([
                    Timestamps::make(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('verified_at')
                    ->label('Ver.')
                    ->tooltip(fn ($record) => 'Verified: '.($record->verified_at ?? 'Not yet verified'))
                    ->formatStateUsing(fn ($state) => $state ? '✔' : '❌'),
                TextColumn::make('participant_verified_at')
                    ->label('Part. Ver.')
                    ->tooltip(fn ($record) => 'Participant Verified: '.($record->participant_verified_at ?? 'Not yet verified'))
                    ->formatStateUsing(fn ($state) => $state ? '✔' : '❌'),
                TextColumn::make('participant.name')
                    ->limit(20),
                TextColumn::make('business.name')
                    ->limit(20),
                TextColumn::make('support_item'),
                TextColumn::make('price_charged')
                    ->formatStateUsing(fn ($state) => '$'.$state),
                TextColumn::make('allocated_amount')
                    ->formatStateUsing(fn ($state) => '$'.$state),
                // TextColumn::make('start_date'),
                // TextColumn::make('end_date'),
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
            'index' => Pages\ListAllocations::route('/'),
            'create' => Pages\CreateAllocation::route('/create'),
            'view' => Pages\ViewAllocation::route('/{record}'),
            'edit' => Pages\EditAllocation::route('/{record}/edit'),
        ];
    }
}
