<?php

namespace App\Enum;

use Datomatic\LaravelEnumHelper\LaravelEnumHelper;

enum DomainType: string
{
    use LaravelEnumHelper;

    case REDIRECT = 'redirect';
    case WEBSITE = 'website';
    case SERVICE = 'service';
}
