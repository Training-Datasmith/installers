<?php

namespace Composer\Installers;

class BonefishInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'package'    => 'Packages/{$vendor}/{$name}/'
    ];
}
