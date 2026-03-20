<?php

declare (strict_types=1);
namespace Composer\Installers;

class Lithium_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['library' => 'libraries/{$name}/', 'source' => 'libraries/_source/{$name}/'];
}