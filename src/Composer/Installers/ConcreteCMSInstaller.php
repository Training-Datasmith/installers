<?php

declare(strict_types=1);

namespace Composer\Installers;

class ConcreteCMSInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'core'       => 'concrete/',
        'block'      => 'application/blocks/{$name}/',
        'package'    => 'packages/{$name}/',
        'theme'      => 'application/themes/{$name}/',
        'update'     => 'updates/{$name}/',
    ];
}
