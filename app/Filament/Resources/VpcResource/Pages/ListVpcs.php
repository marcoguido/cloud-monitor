<?php

namespace App\Filament\Resources\VpcResource\Pages;

use App\Filament\Resources\VpcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVpcs extends ListRecords
{
    protected static string $resource = VpcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
