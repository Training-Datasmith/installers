<?php

namespace Composer\Installers;

class ZikulaInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'modules/{$vendor}-{$name}/',
        'theme'  => 'themes/{$vendor}-{$name}/'
    ];
}
