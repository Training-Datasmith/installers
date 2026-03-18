<?php

declare(strict_types=1);

namespace Composer\Installers;

class PortoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'container' => 'app/Containers/{$name}/',
    ];
}
