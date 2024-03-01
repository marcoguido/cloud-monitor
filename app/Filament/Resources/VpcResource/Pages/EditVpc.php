<?php

namespace App\Filament\Resources\VpcResource\Pages;

use App\Filament\Resources\VpcResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVpc extends EditRecord
{
    protected static string $resource = VpcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
