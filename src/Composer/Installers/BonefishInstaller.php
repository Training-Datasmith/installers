<?php

declare(strict_types=1);

namespace Composer\Installers;

class BonefishInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'package'    => 'Packages/{$vendor}/{$name}/',
    ];
}
