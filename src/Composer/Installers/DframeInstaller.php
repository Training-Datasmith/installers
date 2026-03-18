<?php

namespace Composer\Installers;

class DframeInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module'  => 'modules/{$vendor}/{$name}/',
    ];
}
