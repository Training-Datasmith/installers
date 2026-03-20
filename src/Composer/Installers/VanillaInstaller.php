<?php

declare (strict_types=1);
namespace Composer\Installers;

class Vanilla_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'plugins/{$name}/', 'theme' => 'themes/{$name}/'];
}