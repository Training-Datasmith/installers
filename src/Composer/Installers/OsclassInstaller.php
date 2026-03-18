<?php

declare(strict_types=1);

namespace Composer\Installers;

class OsclassInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin' => 'oc-content/plugins/{$name}/',
        'theme' => 'oc-content/themes/{$name}/',
        'language' => 'oc-content/languages/{$name}/',
    ];
}
