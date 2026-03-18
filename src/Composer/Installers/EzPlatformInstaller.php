<?php

declare(strict_types=1);

namespace Composer\Installers;

class EzPlatformInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'meta-assets' => 'web/assets/ezplatform/',
        'assets' => 'web/assets/ezplatform/{$name}/',
    ];
}
