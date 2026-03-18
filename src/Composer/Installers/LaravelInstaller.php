<?php

declare(strict_types=1);

namespace Composer\Installers;

class LaravelInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'library' => 'libraries/{$name}/',
    ];
}
