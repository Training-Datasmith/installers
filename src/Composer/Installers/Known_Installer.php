<?php

declare (strict_types=1);
namespace Composer\Installers;

class Known_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'IdnoPlugins/{$name}/', 'theme' => 'Themes/{$name}/', 'console' => 'ConsolePlugins/{$name}/'];
}