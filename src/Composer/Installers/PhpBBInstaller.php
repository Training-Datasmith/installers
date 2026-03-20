<?php

declare (strict_types=1);
namespace Composer\Installers;

class Php_Bb_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['extension' => 'ext/{$vendor}/{$name}/', 'language' => 'language/{$name}/', 'style' => 'styles/{$name}/'];
}