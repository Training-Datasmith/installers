<?php

declare (strict_types=1);
namespace Composer\Installers;

class Fuel_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'fuel/app/modules/{$name}/', 'package' => 'fuel/packages/{$name}/', 'theme' => 'fuel/app/themes/{$name}/'];
}