<?php

namespace App\Actions\Monitor;

use App\Enum\EventStatus;
use App\Enum\EventType;
use App\Models\Monitor;
use App\Models\ValueObjects\Event\SslData;
use Spatie\SslCertificate\SslCertificate;

class ProcessSslCertificateData
{
    public function __invoke(Monitor $monitor, SslCertificate $certificate)
    {
        $monitor
            ->events()
            ->create([
                'type' => EventType::SSL_CHECK,
                'status' => $certificate->isValid()
                    ? EventStatus::SUCCESS
                    : EventStatus::FAILURE,
                'payload' => new SslData(
                    $certificate->daysUntilExpirationDate(),
                    $certificate->expirationDate(),
                    $certificate->getFingerprint(),
                    $certificate->getFingerprintSha256(),
                ),
            ]);
    }
}
