<?php

namespace Composer\Installers;

class FuelphpInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'component'  => 'components/{$name}/',
    ];
}
