<?php

declare (strict_types=1);
namespace Composer\Installers;

class Dframe_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$vendor}/{$name}/'];
}