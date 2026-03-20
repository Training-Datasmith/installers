<?php

declare (strict_types=1);
namespace Composer\Installers;

class Decibel_Installer extends Base_Installer
{
    /** @var array */
    /** @var array<string, string> */
    protected $locations = ['app' => 'app/{$name}/'];
}