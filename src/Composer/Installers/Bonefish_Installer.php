<?php

declare (strict_types=1);
namespace Composer\Installers;

class Bonefish_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['package' => 'Packages/{$vendor}/{$name}/'];
}