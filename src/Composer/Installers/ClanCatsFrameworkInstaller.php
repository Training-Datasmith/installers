<?php

namespace Composer\Installers;

class ClanCatsFrameworkInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'ship'      => 'CCF/orbit/{$name}/',
        'theme'     => 'CCF/app/themes/{$name}/',
    ];
}
