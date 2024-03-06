<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Monitor
 *
 * @property-read \App\Models\Domain|null $domain
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor query()
 *
 * @property int $id
 * @property string $slug
 * @property bool $ssl_check
 * @property bool $ping_check Whether to perform healthcheck verifications
 * @property string|null $ping_endpoint The url to be used to perform healthcheck verifications. If null, domain base URL will be used
 * @property int $domain_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereDomainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor wherePingCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor wherePingEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereSslCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUpdatedAt($value)
 *
 * @property int $update_frequency
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereUpdateFrequency($value)
 *
 * @property \Carbon\CarbonImmutable|null $last_ssl_check
 * @property \Carbon\CarbonImmutable|null $last_ping_check
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereLastPingCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Monitor whereLastSslCheck($value)
 *
 * @mixin \Eloquent
 */
class Monitor extends Model
{
    use HasFactory,
        HasSlug;

    protected $fillable = [
        'slug',
        'domain_id',
        'update_frequency',
        'ssl_check',
        'ping_check',
        'ping_endpoint',
        'last_ssl_check',
        'last_ping_check',
    ];

    protected $casts = [
        'update_frequency' => 'int',
        'ssl_check' => 'bool',
        'ping_check' => 'bool',
        'last_ssl_check' => 'immutable_datetime',
        'last_ping_check' => 'immutable_datetime',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(
                fn () => Domain::find($this->domain_id)->name,
            )
            ->saveSlugsTo('slug');
    }

    public function pingCheckExpired(): bool
    {
        $now = CarbonImmutable::now();

        if (! $this->ping_check) {
            return false;
        }

        if ($this->last_ping_check === null) {
            return true;
        }

        return $this->last_ping_check
            ->addMinutes($this->update_frequency)
            ->isBefore($now);
    }
}
