<?php

declare(strict_types=1);

namespace Composer\Installers;

class AttogramInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'modules/{$name}/',
    ];
}
