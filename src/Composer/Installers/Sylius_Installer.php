<?php

declare (strict_types=1);
namespace Composer\Installers;

class Sylius_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['theme' => 'themes/{$name}/'];
}