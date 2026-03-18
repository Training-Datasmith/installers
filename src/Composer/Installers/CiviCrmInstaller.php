<?php

declare(strict_types=1);

namespace Composer\Installers;

class CiviCrmInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'ext'    => 'ext/{$name}/',
    ];
}
