<?php

declare(strict_types=1);

namespace Composer\Installers;

class PantheonInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'script' => 'web/private/scripts/quicksilver/{$name}',
        'module' => 'web/private/scripts/quicksilver/{$name}',
    ];
}
