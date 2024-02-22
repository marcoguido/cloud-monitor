<?php

namespace App\Models;

use App\Enum\OperatingSystem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Tags\HasTags;

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
