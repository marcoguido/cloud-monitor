<?php

namespace App\Models;

use App\Enum\OperatingSystem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

/**
 * App\Models\Vpc
 *
 * @property int $id
 * @property string $name
 * @property OperatingSystem $operating_system
 * @property string $operating_system_release
 * @property string|null $hostname
 * @property string|null $public_ip
 * @property string|null $private_ip
 * @property bool $is_ssh_enabled
 * @property int $ssh_port
 * @property string|null $management_url
 * @property string|null $password_manager_credentials_url
 * @property int $cluster_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereClusterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereIsSshEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereManagementUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereOperatingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereOperatingSystemRelease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc wherePasswordManagerCredentialsUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc wherePrivateIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc wherePublicIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereSshPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc whereUpdatedAt($value)
 *
 * @property-read \App\Models\Cluster $cluster
 * @property \Illuminate\Database\Eloquent\Collection<int, \Spatie\Tags\Tag> $tags
 * @property-read int|null $tags_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|Vpc withoutTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 *
 * @mixin \Eloquent
 */
class Vpc extends Model
{
    use HasFactory,
        HasTags;

    protected $fillable = [
        'name',
        'operating_system',
        'operating_system_release',
        'hostname',
        'public_ip',
        'private_ip',
        'is_ssh_enabled',
        'ssh_port',
        'management_url',
        'password_manager_credentials_url',
        'cluster_id',
    ];

    protected $casts = [
        'operating_system' => OperatingSystem::class,
        'is_ssh_enabled' => 'bool',
        'ssh_port' => 'integer',
    ];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }
}
