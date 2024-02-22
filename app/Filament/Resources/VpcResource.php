<?php

namespace App\Filament\Resources;

use App\Enum\OperatingSystem;
use App\Filament\Resources\VpcResource\Pages;
use App\Filament\Resources\VpcResource\RelationManagers;
use App\Models\Vpc;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Markdown;
use Filament\Tables;
use Filament\Tables\Table;

class VpcResource extends Resource
{
    protected static ?string $model = Vpc::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'VPC';
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ])
            ->filters([
                //
            ])
            ->actions([
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
