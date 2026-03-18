<?php

declare(strict_types=1);

namespace Composer\Installers;

class ItopInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'extension'    => 'extensions/{$name}/',
    ];
}
