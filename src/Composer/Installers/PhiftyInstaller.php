<?php

namespace Composer\Installers;

class PhiftyInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'bundle' => 'bundles/{$name}/',
        'library' => 'libraries/{$name}/',
        'framework' => 'frameworks/{$name}/',
    ];
}
