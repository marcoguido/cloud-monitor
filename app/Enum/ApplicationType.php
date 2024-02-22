<?php

namespace App\Enum;

use Datomatic\LaravelEnumHelper\LaravelEnumHelper;

enum ApplicationType: string
{
    use LaravelEnumHelper;

    case PLAIN_PHP = 'plain_php';
    case LARAVEL = 'laravel';
    case JAVASCRIPT_SPA = 'javascript_spa';
    case PLAIN_HTML = 'plain_html';
    case DOT_NET = 'dot_net';
}
