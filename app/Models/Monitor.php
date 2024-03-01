<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @mixin \Eloquent
 */
class Monitor extends Model
{
    use HasFactory,
        HasSlug;

    protected $fillable = [
        'slug',
        'domain_id',
        'ssl_check',
        'ping_check',
        'ping_endpoint',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
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
}
