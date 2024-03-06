<?php

namespace App\Filament\Resources;

use App\Enum\OperatingSystem;
use App\Filament\Resources\VpcResource\Pages;
use App\Models\Vpc;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Markdown;
use Filament\Tables;
use Filament\Tables\Table;

class VpcResource extends Resource
{
    protected static ?string $model = Vpc::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'VPC';

    protected static ?string $pluralModelLabel = 'VPCs';

    protected static ?string $navigationIcon = 'heroicon-o-server-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('cluster_id')
                    ->columnSpanFull()
                    ->relationship(name: 'cluster', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Select::make('operating_system')
                    ->required()
                    ->options(OperatingSystem::descriptionsByValue()),
                TextInput::make('operating_system_release')
                    ->label('OS Version')
                    ->required(),
                TextInput::make('hostname')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('public_ip')
                    ->required()
                    ->ip(),
                TextInput::make('private_ip')
                    ->ip(),
                TextInput::make('management_url')
                    ->columnSpanFull()
                    ->helperText('Plesk, cPanel or Webmin url (if any)')
                    ->url(),
                TextInput::make('password_manager_credentials_url')
                    ->columnSpanFull()
                    ->helperText(
                        Markdown::inline('The url to the credentials mapped in [Passbolt](https://passbolt.eegatech.it)'),
                    )
                    ->url(),
                SpatieTagsInput::make('tags')
                    ->type('vpc_tags')
                    ->columnSpanFull(),
                Toggle::make('is_ssh_enabled')
                    ->label('SSH Allowed?')
                    ->default(true)
                    ->live(),
                TextInput::make('ssh_port')
                    ->numeric()
                    ->minValue(0)
                    ->default(22)
                    ->required(
                        fn (Get $get) => $get('is_ssh_enabled'),
                    )
                    ->hidden(
                        fn (Get $get) => ! $get('is_ssh_enabled'),
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cluster.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('public_ip')
                    ->label('Public IP')
                    ->copyable(),
                Tables\Columns\TextColumn::make('operating_system')
                    ->formatStateUsing(
                        fn (Vpc $record) => "{$record->operating_system->description()} $record->operating_system_release",
                    )
                    ->badge(),
                Tables\Columns\SpatieTagsColumn::make('tags')
                    ->type('vpc_tags'),
                Tables\Columns\IconColumn::make('is_ssh_enabled')
                    ->label('SSH allowed?')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('management_url')
                    ->label('VPS Manager')
                    ->hidden(
                        fn (Vpc $record): bool => empty($record->management_url),
                    )
                    ->url(
                        url: fn (Vpc $record): string => $record->management_url,
                        shouldOpenInNewTab: true,
                    )
                    ->icon('heroicon-o-wrench-screwdriver'),
                Tables\Actions\Action::make('password_manager_credentials_url')
                    ->label('VPC Credentials')
                    ->hidden(
                        fn (Vpc $record): bool => empty($record->password_manager_credentials_url),
                    )
                    ->url(
                        url: fn (Vpc $record): string => $record->password_manager_credentials_url,
                        shouldOpenInNewTab: true,
                    )
                    ->icon('heroicon-o-key'),
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
            'index' => Pages\ListVpcs::route('/'),
            'create' => Pages\CreateVpc::route('/create'),
            'edit' => Pages\EditVpc::route('/{record}/edit'),
        ];
    }
}
