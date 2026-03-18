<?php

declare(strict_types=1);

namespace Composer\Installers;

class UserFrostingInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'sprinkle' => 'app/sprinkles/{$name}/',
    ];
}
