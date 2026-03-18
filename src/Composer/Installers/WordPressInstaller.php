<?php

namespace Composer\Installers;

class WordPressInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin'    => 'wp-content/plugins/{$name}/',
        'theme'     => 'wp-content/themes/{$name}/',
        'muplugin'  => 'wp-content/mu-plugins/{$name}/',
        'dropin'    => 'wp-content/{$name}/',
    ];
}
