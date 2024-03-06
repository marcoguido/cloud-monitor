<?php

namespace App\Actions\Monitor;

use App\Enum\EventStatus;
use App\Enum\EventType;
use App\Models\Monitor;
use App\Models\ValueObjects\Event\SslData;
use Spatie\QueueableAction\QueueableAction;
use Spatie\SslCertificate\SslCertificate;

class ProcessSslCertificateData
{
    use QueueableAction;

    public function __invoke(Monitor $monitor, string $certificateUrl): void
    {
        $certificate = SslCertificate::createForHostName($certificateUrl);

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
