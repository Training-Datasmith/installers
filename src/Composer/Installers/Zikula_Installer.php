<?php

declare (strict_types=1);
namespace Composer\Installers;

class Zikula_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$vendor}-{$name}/', 'theme' => 'themes/{$vendor}-{$name}/'];
}