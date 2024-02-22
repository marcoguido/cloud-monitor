<?php

namespace App\Models;

use App\Enum\ApplicationType;
use App\Enum\DomainType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

/**
 * App\Models\Domain
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string|null $description
 * @property DomainType $domain_type
 * @property ApplicationType|null $application_type
 * @property string|null $remote_system_user
 * @property string|null $remote_path
 * @property string|null $remote_php_path
 * @property string|null $ssh_private_key
 * @property int $dns_provider_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereApplicationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDnsProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDomainType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereRemotePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereRemotePhpPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereRemoteSystemUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUrl($value)
 *
 * @property-read \App\Models\Provider $provider
 * @property \Illuminate\Database\Eloquent\Collection<int, \Spatie\Tags\Tag> $tags
 * @property-read int|null $tags_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereSshPrivateKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain withoutTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 *
 * @mixin \Eloquent
 */
class Domain extends Model
{
    use HasFactory,
        HasTags;

    protected $fillable = [
        'name',
        'url',
        'description',
        'domain_type',
        'application_type',
        'remote_system_user',
        'remote_path',
        'remote_php_path',
        'ssh_private_key',
        'dns_provider_id',
    ];

    protected $casts = [
        'domain_type' => DomainType::class,
        'application_type' => ApplicationType::class,
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'dns_provider_id');
    }
}
