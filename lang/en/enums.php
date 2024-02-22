<?php

use App\Enum\ApplicationType;
use App\Enum\DomainType;
use App\Enum\OperatingSystem;

return [
    OperatingSystem::class => [
        'description' => [
            OperatingSystem::UBUNTU_LINUX->name => 'Ubuntu Linux',
            OperatingSystem::UBUNTU_LINUX_ARM->name => 'Ubuntu Linux (ARM)',
            OperatingSystem::WINDOWS->name => 'Windows',
            OperatingSystem::WINDOWS_ARM->name => 'Windows (ARM)',
            OperatingSystem::WINDOWS_SERVER->name => 'Windows Server',
            OperatingSystem::WINDOWS_SERVER_ARM->name => 'Windows Server (ARM)',
        ],
    ],
    ApplicationType::class => [
        'description' => [
            ApplicationType::PLAIN_PHP->name => 'Plain PHP',
            ApplicationType::LARAVEL->name => 'Laravel',
            ApplicationType::JAVASCRIPT_SPA->name => 'JavaScript-based SPA',
            ApplicationType::PLAIN_HTML->name => 'Plain HTML',
            ApplicationType::DOT_NET->name => '.Net',
        ],
    ],
    DomainType::class => [
        'description' => [
            DomainType::REDIRECT->name => 'Redirect',
            DomainType::WEBSITE->name => 'Website',
            DomainType::SERVICE->name => 'Exposed system service',
        ]
    ],
];
