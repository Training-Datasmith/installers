<?php

namespace Composer\Installers;

class LaravelInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'library' => 'libraries/{$name}/',
    ];
}
