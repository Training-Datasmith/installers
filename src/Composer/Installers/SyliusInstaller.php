<?php

declare(strict_types=1);

namespace Composer\Installers;

class SyliusInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'theme' => 'themes/{$name}/',
    ];
}
