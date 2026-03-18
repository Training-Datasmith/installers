<?php

declare(strict_types=1);

namespace Composer\Installers;

class ZendInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'library' => 'library/{$name}/',
        'extra'   => 'extras/library/{$name}/',
        'module'  => 'module/{$name}/',
    ];
}
