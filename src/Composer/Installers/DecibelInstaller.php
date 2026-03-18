<?php

declare(strict_types=1);

namespace Composer\Installers;

class DecibelInstaller extends BaseInstaller
{
    /** @var array */
    /** @var array<string, string> */
    protected $locations = [
        'app'    => 'app/{$name}/',
    ];
}
