<?php

declare (strict_types=1);
namespace Composer\Installers;

class Puppet_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$name}/'];
}