<?php

namespace Composer\Installers;

class PPIInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'modules/{$name}/',
    ];
}
