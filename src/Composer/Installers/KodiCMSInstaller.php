<?php

declare(strict_types=1);

namespace Composer\Installers;

class KodiCMSInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin' => 'cms/plugins/{$name}/',
        'media'  => 'cms/media/vendor/{$name}/',
    ];
}
