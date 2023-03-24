<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaimResource\Pages;
use App\Models\Claim;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use FilamentAddons\Forms\Components\Separator;
use FilamentAddons\Forms\Components\Timestamps;
use Illuminate\Support\HtmlString;

class ClaimResource extends Resource
{
    protected static ?string $model = Claim::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(['default' => 1])->schema([
                    Forms\Components\Placeholder::make('id')->label('Internal ID')
                        ->content(fn ($record) => $record->id),
                ]),

                Forms\Components\Grid::make(['default' => 1])->schema([
                    Separator::make(),
                ]),

                Forms\Components\TextInput::make('claimed_amount')->disabled(),
                Forms\Components\TextInput::make('qty')->disabled(),
                Forms\Components\TextInput::make('total')->disabled(),
                Forms\Components\DatePicker::make('from'),
                Forms\Components\DatePicker::make('to'),
                Forms\Components\Grid::make(['default' => 1])->schema([
                    Separator::make(),
                ]),

                Forms\Components\Placeholder::make('business')->label('Bill ID')
                    ->content(fn ($record) => new HtmlString("<a target=\"_blank\" href=\"https://go.xero.com/AccountsPayable/Edit.aspx?InvoiceID={$record->bill->bill_id}\">{$record->bill->bill_id}</a>")),
                Forms\Components\Placeholder::make('business')->label('Invoice ID')
                    ->content(fn ($record) => new HtmlString("<a target=\"_blank\" href=\"https://invoicing.xero.com/edit/{$record->invoice->invoice_id}\">{$record->invoice->invoice_id}</a>")),

                Forms\Components\Placeholder::make('business')->label('Business')
                    ->content(fn ($record) => $record->allocation->business->name),
                Forms\Components\Placeholder::make('business')->label('Participant')
                    ->content(fn ($record) => $record->allocation->participant->name),

                Forms\Components\Grid::make(['default' => 1])->schema([
                    Separator::make(),
                ]),

                Forms\Components\Grid::make()->schema([
                    Timestamps::make(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('to')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('claimed_amount')
                    ->label('Claim Amount')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty')
                    ->label('Qty')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('allocation.business.name')
                    ->label('Business')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('allocation.participant.name')
                    ->label('Participant')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListClaims::route('/'),
            'create' => Pages\CreateClaim::route('/create'),
            'view' => Pages\ViewClaim::route('/{record}'),
            'edit' => Pages\EditClaim::route('/{record}/edit'),
        ];
    }
}
