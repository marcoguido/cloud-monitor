<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Models\Provider;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationIcon = 'heroicon-o-wifi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->required()
                    ->url(),
                TextInput::make('backoffice_url')
                    ->url(),
                TextInput::make('ticketing_url')
                    ->url(),
                TextInput::make('domain_management_url')
                    ->url(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('backoffice_url')
                    ->label('Backoffice access')
                    ->hidden(
                        fn (Provider $record): bool => empty($record->backoffice_url),
                    )
                    ->url(
                        url: fn (Provider $record): string => $record->backoffice_url,
                        shouldOpenInNewTab: true,
                    )
                    ->icon('heroicon-o-adjustments-horizontal'),
                Tables\Actions\Action::make('ticketing_url')
                    ->label('Ticketing')
                    ->hidden(
                        fn (Provider $record): bool => empty($record->ticketing_url),
                    )
                    ->url(
                        url: fn (Provider $record): string => $record->ticketing_url,
                        shouldOpenInNewTab: true,
                    )
                    ->icon('heroicon-o-ticket'),
                Tables\Actions\Action::make('domain_management_url')
                    ->label('DNS/Domain Management')
                    ->hidden(
                        fn (Provider $record): bool => empty($record->domain_management_url),
                    )
                    ->url(
                        url: fn (Provider $record): string => $record->domain_management_url,
                        shouldOpenInNewTab: true,
                    )
                    ->icon('heroicon-o-globe-alt'),
                Tables\Actions\Action::make('url')
                    ->label('Official site')
                    ->hidden(
                        fn (Provider $record): bool => empty($record->url),
                    )
                    ->url(
                        url: fn (Provider $record): string => $record->url,
                        shouldOpenInNewTab: true,
                    )
                    ->icon('heroicon-o-link'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}
