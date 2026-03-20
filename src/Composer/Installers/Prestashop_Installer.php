<?php

declare (strict_types=1);
namespace Composer\Installers;

class Prestashop_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$name}/', 'theme' => 'themes/{$name}/'];
}