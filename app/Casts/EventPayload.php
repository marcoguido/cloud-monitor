<?php

namespace App\Casts;

use App\Enum\EventType;
use App\Models\Event;
use App\Models\ValueObjects\Event\EventPayloadData;
use App\Models\ValueObjects\Event\PingData;
use App\Models\ValueObjects\Event\SslData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class EventPayload implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  Event  $model
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $model->type instanceof EventType) {
            return null;
        }

        $payloadData = json_decode($value);

        if ($model->type->is(EventType::SSL_CHECK)) {
            return new SslData(
                $payloadData->days_until_expiration,
                $payloadData->expiration_date,
                $payloadData->fingerprint,
                $payloadData->fingerprint_sha_256,
            );
        }

        if ($model->type->is(EventType::PING)) {
            return new PingData(
                $payloadData->endpoint,
                $payloadData->request_method,
                $payloadData->response_http_code,
                $payloadData->headers,
                $payloadData->body,
            );
        }
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof EventPayloadData) {
            throw new InvalidArgumentException('The given value is not an `EventPayloadData` instance.');
        }

        return [
            'payload' => json_encode($value->toArray()),
        ];
    }
}
