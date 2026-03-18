<?php

namespace Composer\Installers;

class KohanaInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'modules/{$name}/',
    ];
}
