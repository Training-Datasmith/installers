<?php

declare(strict_types=1);

namespace Composer\Installers;

class VanillaInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin'    => 'plugins/{$name}/',
        'theme'     => 'themes/{$name}/',
    ];
}
