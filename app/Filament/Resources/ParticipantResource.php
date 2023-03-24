<?php

namespace App\Filament\Resources;

use App\Enums\AuthRole;
use App\Filament\Resources\ParticipantResource\Pages;
use App\Models\Participant;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('created_at')
                    ->visibleOn('view'),
                DateTimePicker::make('updated_at')
                    ->visibleOn('view'),
                TextInput::make('ndis')
                    ->label('NDIS Number')
                    ->unique(ignoreRecord: true)
                    ->integer()
                    ->length(9),
                TextInput::make('name'),
                TextInput::make('email')
                    ->label('Authorizing Email')
                    ->unique(ignoreRecord: true)
                    ->email()
                    ->maxLength(255),
                Select::make('auth_role')
                    ->label('Authorizing Role')
                    ->options(AuthRole::class),
                TextInput::make('email1')
                    ->label('Alternate Email 1')
                    ->email()
                    ->maxLength(255),
                TextInput::make('email2')
                    ->label('Alternate Email 2')
                    ->email()
                    ->maxLength(255),
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
                TextColumn::make('ndis')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('auth_role')
                    ->formatStateUsing(fn ($state) => array_column(AuthRole::cases(), 'name', 'value')[$state]),
                TextColumn::make('createdBy.name')
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
            'index' => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'view' => Pages\ViewParticipant::route('/{record}'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
