<?php

namespace App\Enum;

use Datomatic\LaravelEnumHelper\LaravelEnumHelper;

enum EventType: string
{
    use LaravelEnumHelper;

    case SSL_CHECK = 'ssl';
    case PING = 'ping';
}
