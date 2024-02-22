<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Cluster
 *
 * @property int $id
 * @property string $name
 * @property int $provider_id
 * @property string|null $management_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereManagementUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cluster whereUpdatedAt($value)
 *
 * @property-read \App\Models\Provider $provider
 *
 * @mixin \Eloquent
 */
class Cluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'provider_id',
        'management_url',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
