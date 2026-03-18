<?php

namespace Composer\Installers;

class LavaLiteInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'package' => 'packages/{$vendor}/{$name}/',
        'theme'   => 'public/themes/{$name}/',
    ];
}
