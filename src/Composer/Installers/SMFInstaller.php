<?php

namespace Composer\Installers;

class SMFInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'Sources/{$name}/',
        'theme' => 'Themes/{$name}/',
    ];
}
