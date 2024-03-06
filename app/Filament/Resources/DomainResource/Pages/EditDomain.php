<?php

namespace App\Filament\Resources\DomainResource\Pages;

use App\Filament\Resources\DomainResource;
use App\Models\Domain;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\EditRecord;

class EditDomain extends EditRecord
{
    protected static string $resource = DomainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('updateSshKey')
                ->visible(
                    fn (Domain $record) => $record->remote_system_user !== null,
                )
                ->form([
                    Textarea::make('ssh_private_key')
                        ->nullable()
                        ->placeholder('May start with -----BEGIN OPENSSH PRIVATE KEY-----')
                        ->helperText('The private key (without any passphrase) to be used to connect to remote server'),
                ])
                ->action(
                    function (array $data, Domain $record): void {
                        $record->ssh_private_key = $data['ssh_private_key'];
                        $record->save();
                    },
                ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
