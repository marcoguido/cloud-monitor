<?php

namespace App\Models\ValueObjects\Event;

readonly class PingData implements EventPayloadData
{
    public function __construct(
        public ?string $endpoint,
        public ?string $requestMethod,
        public ?int $responseHttpCode,
        public ?array $headers,
        public ?string $body,
    ) {
    }

    public function toArray(): array
    {
        return [
            'endpoint' => $this->endpoint,
            'request_method' => $this->requestMethod,
            'response_http_code' => $this->responseHttpCode,
            'headers' => $this->headers,
            'body' => $this->body,
        ];
    }
}
