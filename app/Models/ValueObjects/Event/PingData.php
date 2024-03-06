<?php

namespace App\Models\ValueObjects\Event;

class PingData implements EventPayloadData
{
    public function toArray(): array
    {
        return [];
    }
}
