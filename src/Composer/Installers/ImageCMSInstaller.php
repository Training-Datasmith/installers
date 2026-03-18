<?php

namespace Composer\Installers;

class ImageCMSInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'template'    => 'templates/{$name}/',
        'module'      => 'application/modules/{$name}/',
        'library'     => 'application/libraries/{$name}/',
    ];
}
