<?php

namespace App\Enum;

use Datomatic\LaravelEnumHelper\LaravelEnumHelper;

enum OperatingSystem: string
{
    use LaravelEnumHelper;

    case UBUNTU_LINUX = 'ubuntu_linux_amd64';
    case UBUNTU_LINUX_ARM = 'ubuntu_linux_arm';
    case WINDOWS = 'windows_amd64';
    case WINDOWS_ARM = 'windows_arm';
    case WINDOWS_SERVER = 'windows_server_amd64';
    case WINDOWS_SERVER_ARM = 'windows_server_arm';
}
