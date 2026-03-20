<?php

declare (strict_types=1);
namespace Composer\Installers;

class Smf_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'Sources/{$name}/', 'theme' => 'Themes/{$name}/'];
}