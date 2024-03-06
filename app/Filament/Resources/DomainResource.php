<?php

namespace App\Filament\Resources;

use App\Enum\ApplicationType;
use App\Enum\DomainType;
use App\Filament\Resources\DomainResource\Pages;
use App\Models\Domain;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DomainResource extends Resource
{
    protected static ?string $model = Domain::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('domain_type')
                    ->options(DomainType::descriptionsByValue())
                    ->default(DomainType::WEBSITE)
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->columnSpanFull()
                    ->required()
                    ->url(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('application_type')
                    ->options(ApplicationType::descriptionsByValue())
                    ->nullable(),
                SpatieTagsInput::make('application_environment')
                    ->type('application_environments')
                    ->nullable(),
                TextInput::make('remote_system_user')
                    ->columnSpanFull()
                    ->nullable()
                    ->maxLength(255),
                TextInput::make('remote_path')
                    ->nullable()
                    ->helperText('The path to the directory being served in remote server for this domain'),
                TextInput::make('remote_php_path')
                    ->nullable()
                    ->helperText('The path to the PHP executable running the application (if any)'),
                Textarea::make('ssh_private_key')
                    ->columnSpanFull()
                    ->nullable()
                    ->placeholder('May start with -----BEGIN OPENSSH PRIVATE KEY-----')
                    ->hiddenOn('edit')
                    ->helperText('The private key (without any passphrase) to be used to connect to remote server'),
                Select::make('dns_provider_id')
                    ->label('DNS Provider')
                    ->relationship(name: 'provider', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('Which provider holds DNS configuration for the site')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('domain_type')
                    ->formatStateUsing(
                        fn (Domain $record) => $record->domain_type->description(),
                    )
                    ->badge(),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('url')
                    ->url(
                        url: fn (Domain $record) => $record->url,
                        shouldOpenInNewTab: true,
                    ),
                Tables\Columns\TextColumn::make('application_type')
                    ->formatStateUsing(
                        fn (Domain $record) => $record->application_type->description(),
                    )
                    ->badge(),
                Tables\Columns\SpatieTagsColumn::make('application_environment')
                    ->type('application_environments'),
                Tables\Columns\TextColumn::make('provider.name')
                    ->label('DNS Provider')
                    ->url(
                        url: fn (Domain $record) => $record->provider->domain_management_url,
                        shouldOpenInNewTab: true,
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListDomains::route('/'),
            'create' => Pages\CreateDomain::route('/create'),
            'edit' => Pages\EditDomain::route('/{record}/edit'),
        ];
    }
}
