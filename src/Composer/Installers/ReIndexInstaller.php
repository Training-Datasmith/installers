<?php

declare(strict_types=1);

namespace Composer\Installers;

class ReIndexInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'theme'     => 'themes/{$name}/',
        'plugin'    => 'plugins/{$name}/',
    ];
}
