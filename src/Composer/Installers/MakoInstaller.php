<?php

declare(strict_types=1);

namespace Composer\Installers;

class MakoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'package' => 'app/packages/{$name}/',
    ];
}
