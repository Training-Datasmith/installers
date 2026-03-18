<?php

namespace Composer\Installers;

class LithiumInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'library' => 'libraries/{$name}/',
        'source'  => 'libraries/_source/{$name}/',
    ];
}
