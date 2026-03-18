<?php

namespace Composer\Installers;

class RedaxoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'addon'          => 'redaxo/include/addons/{$name}/',
        'bestyle-plugin' => 'redaxo/include/addons/be_style/plugins/{$name}/'
    ];
}
