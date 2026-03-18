<?php

declare(strict_types=1);

namespace Composer\Installers;

class ChefInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'cookbook'  => 'Chef/{$vendor}/{$name}/',
        'role'      => 'Chef/roles/{$name}/',
    ];
}
