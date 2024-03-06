<?php

namespace App\Actions\Monitor;

use App\Enum\EventType;
use App\Models\Monitor;
use Carbon\CarbonImmutable;
use Spatie\QueueableAction\QueueableAction;

class TrackMonitorLastCheckTimestamps
{
    use QueueableAction;

    public function __invoke(Monitor $monitor, EventType $type): void
    {
        $now = CarbonImmutable::now();

        if ($type->is(EventType::SSL_CHECK)) {
            $monitor->last_ssl_check = $now;
        }

        if ($type->is(EventType::PING)) {
            $monitor->last_ping_check = $now;
        }

        $monitor->save();
    }
}
