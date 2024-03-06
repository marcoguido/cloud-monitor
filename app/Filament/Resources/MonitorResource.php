<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonitorResource\Pages;
use App\Models\Domain;
use App\Models\Monitor;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MonitorResource extends Resource
{
    protected static ?string $model = Monitor::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('domain_id')
                    ->relationship(name: 'domain', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(
                        fn (Forms\Set $set, $state) => $set(
                            path: 'ping_endpoint',
                            state: Domain::find($state)?->url,
                        ),
                    ),
                TextInput::make('update_frequency')
                    ->helperText('How many minutes should pass between each check lifecycle')
                    ->default(5)
                    ->minValue(1)
                    ->numeric(),
                Toggle::make('ping_check')
                    ->label('Healthcheck enabled?')
                    ->default(true)
                    ->live(),
                TextInput::make('ping_endpoint')
                    ->columnSpanFull()
                    ->helperText('What url to ping for healthcheck')
                    ->visible(
                        fn (Forms\Get $get) => $get('ping_check'),
                    )
                    ->url(),
                Toggle::make('ssl_check')
                    ->label('Check SSL certificate?')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('domain.name'),
                Tables\Columns\TextColumn::make('update_frequency')
                    ->formatStateUsing(
                        fn (int $state) => sprintf(
                            'Every %d minute(s)',
                            $state,
                        ),
                    ),
                Tables\Columns\IconColumn::make('ping_check')
                    ->label('Healthcheck enabled?')
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('ssl_check')
                    ->label('SSL status check')
                    ->boolean()
                    ->alignCenter(),
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
            'index' => Pages\ListMonitors::route('/'),
            'create' => Pages\CreateMonitor::route('/create'),
            'edit' => Pages\EditMonitor::route('/{record}/edit'),
        ];
    }
}
