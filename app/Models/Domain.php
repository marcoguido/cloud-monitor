<?php

namespace App\Models;

use App\Enum\ApplicationType;
use App\Enum\DomainType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

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
