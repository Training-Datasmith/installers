<?php

namespace Composer\Installers;

class AttogramInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => 'modules/{$name}/',
    ];
}
