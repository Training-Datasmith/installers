<?php

declare (strict_types=1);
namespace Composer\Installers;

class Code_Igniter_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['library' => 'application/libraries/{$name}/', 'third-party' => 'application/third_party/{$name}/', 'module' => 'application/modules/{$name}/'];
}