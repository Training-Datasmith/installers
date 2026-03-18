<?php

declare(strict_types=1);

namespace Composer\Installers;

class PrestashopInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'modules/{$name}/',
        'theme'  => 'themes/{$name}/',
    ];
}
