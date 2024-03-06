<?php

namespace App\Models\ValueObjects\Event;

use Carbon\Carbon;
use Exception;

readonly class SslData implements EventPayloadData
{
    public ?Carbon $expirationDate;

    public function __construct(
        public ?int $daysUntilExpiration,
        null|Carbon|string $expirationDate,
        public ?string $fingerprint,
        public ?string $fingerprintSha256,
    ) {
        if (is_string($expirationDate)) {
            try {
                $this->expirationDate = Carbon::parse($expirationDate);
            } catch (Exception) {
                $this->expirationDate = null;
            }
        } else {
            $this->expirationDate = $expirationDate;
        }
    }

    public function toArray(): array
    {
        return [
            'days_until_expiration' => $this->daysUntilExpiration,
            'expiration_date' => $this->expirationDate?->toW3cString(),
            'fingerprint' => $this->fingerprint,
            'fingerprint_sha_256' => $this->fingerprintSha256,
        ];
    }
}
