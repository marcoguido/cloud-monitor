<?php

namespace App\Actions\Monitor;

use App\Models\Monitor;
use Illuminate\Support\Collection;

class FetchAllMonitors
{
    /**
     * @return Collection<Monitor>
     */
    public function __invoke(array $where = [], array $with = []): Collection
    {
        return Monitor::with($with)
            ->where($where)
            ->get();
    }
}
