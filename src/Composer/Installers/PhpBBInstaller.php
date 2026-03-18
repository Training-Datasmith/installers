<?php

declare(strict_types=1);

namespace Composer\Installers;

class PhpBBInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'extension' => 'ext/{$vendor}/{$name}/',
        'language'  => 'language/{$name}/',
        'style'     => 'styles/{$name}/',
    ];
}
