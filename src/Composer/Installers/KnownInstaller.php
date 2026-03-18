<?php

namespace Composer\Installers;

class KnownInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin'    => 'IdnoPlugins/{$name}/',
        'theme'     => 'Themes/{$name}/',
        'console'   => 'ConsolePlugins/{$name}/',
    ];
}
