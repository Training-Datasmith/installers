<?php

declare(strict_types=1);

namespace Composer\Installers;

class EliasisInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'component' => 'components/{$name}/',
        'module'    => 'modules/{$name}/',
        'plugin'    => 'plugins/{$name}/',
        'template'  => 'templates/{$name}/',
    ];
}
