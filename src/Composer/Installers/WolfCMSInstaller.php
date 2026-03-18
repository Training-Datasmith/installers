<?php

namespace Composer\Installers;

class WolfCMSInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin' => 'wolf/plugins/{$name}/',
    ];
}
