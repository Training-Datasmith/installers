<?php

declare(strict_types=1);

namespace Composer\Installers;

class SMFInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'Sources/{$name}/',
        'theme' => 'Themes/{$name}/',
    ];
}
