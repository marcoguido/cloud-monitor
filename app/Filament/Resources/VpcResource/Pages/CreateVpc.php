<?php

namespace App\Filament\Resources\VpcResource\Pages;

use App\Filament\Resources\VpcResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVpc extends CreateRecord
{
    protected static string $resource = VpcResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
