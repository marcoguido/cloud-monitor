<?php

namespace App\Models;

use App\Enum\EventStatus;
use App\Enum\EventType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitor_id',
        'type',
        'status',
        'payload',
    ];

    protected $casts = [
        'type' => EventType::class,
        'status' => EventStatus::class,
    ];

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class);
    }
}
