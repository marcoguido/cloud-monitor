<?php

namespace App\Models;

use App\Casts\EventPayload;
use App\Enum\EventStatus;
use App\Enum\EventType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property EventType $type
 * @property EventStatus $status
 * @property \Illuminate\Support\Collection|null $payload
 * @property int $monitor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Monitor $monitor
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereMonitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
        'payload' => EventPayload::class,
    ];

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class);
    }
}
