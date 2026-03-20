<?php

declare (strict_types=1);
namespace Composer\Installers;

class Miaoxing_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'plugins/{$name}/'];
}