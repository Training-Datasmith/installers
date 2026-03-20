<?php

declare (strict_types=1);
namespace Composer\Installers;

class Mako_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['package' => 'app/packages/{$name}/'];
}