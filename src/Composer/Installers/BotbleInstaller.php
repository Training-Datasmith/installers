<?php

declare(strict_types=1);

namespace Composer\Installers;

class BotbleInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin'     => 'platform/plugins/{$name}/',
        'theme'      => 'platform/themes/{$name}/',
    ];
}
