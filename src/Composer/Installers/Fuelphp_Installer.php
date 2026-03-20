<?php

declare (strict_types=1);
namespace Composer\Installers;

class Fuelphp_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['component' => 'components/{$name}/'];
}