<?php

namespace App\Actions\Monitor;

use App\Enum\EventStatus;
use App\Enum\EventType;
use App\Models\Monitor;
use App\Models\ValueObjects\Event\PingData;
use Illuminate\Support\Facades\Http;
use Spatie\QueueableAction\QueueableAction;

class ProcessPingData
{
    use QueueableAction;

    public function __invoke(Monitor $monitor): void
    {
        $pingResponse = Http::withHeader(
            name: 'Accept',
            value: 'application/json',
        )->get($monitor->ping_endpoint);

        $monitor
            ->events()
            ->create([
                'type' => EventType::PING,
                'status' => $pingResponse->successful()
                    ? EventStatus::SUCCESS
                    : EventStatus::FAILURE,
                'payload' => new PingData(
                    $monitor->ping_endpoint,
                    'GET',
                    $pingResponse->status(),
                    $pingResponse->headers(),
                    $pingResponse->body(),
                ),
            ]);
    }
}
