<?php

declare(strict_types=1);

namespace Composer\Installers;

class AnnotateCmsInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'module'    => 'addons/modules/{$name}/',
        'component' => 'addons/components/{$name}/',
        'service'   => 'addons/services/{$name}/',
    ];
}
