<?php

declare(strict_types=1);

namespace Composer\Installers;

class StarbugInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'modules/{$name}/',
        'theme' => 'themes/{$name}/',
        'custom-module' => 'app/modules/{$name}/',
        'custom-theme' => 'app/themes/{$name}/',
    ];
}
