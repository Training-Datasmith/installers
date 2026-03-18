<?php

namespace Composer\Installers;

class FuelInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module'  => 'fuel/app/modules/{$name}/',
        'package' => 'fuel/packages/{$name}/',
        'theme'   => 'fuel/app/themes/{$name}/',
    ];
}
