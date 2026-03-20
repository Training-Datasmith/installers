<?php

declare (strict_types=1);
namespace Composer\Installers;

class Pantheon_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['script' => 'web/private/scripts/quicksilver/{$name}', 'module' => 'web/private/scripts/quicksilver/{$name}'];
}