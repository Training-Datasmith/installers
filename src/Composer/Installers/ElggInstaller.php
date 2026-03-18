<?php

declare(strict_types=1);

namespace Composer\Installers;

class ElggInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin' => 'mod/{$name}/',
    ];
}
