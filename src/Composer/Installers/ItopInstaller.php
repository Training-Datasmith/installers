<?php

declare (strict_types=1);
namespace Composer\Installers;

class Itop_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['extension' => 'extensions/{$name}/'];
}