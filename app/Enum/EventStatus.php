<?php

namespace App\Enum;

use Datomatic\LaravelEnumHelper\LaravelEnumHelper;

enum EventStatus: string
{
    use LaravelEnumHelper;

    case SUCCESS = 'success';
    case FAILURE = 'failure';
    case UNAVAILABLE = 'unavailable';
}
