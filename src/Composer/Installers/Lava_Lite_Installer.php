<?php

declare (strict_types=1);
namespace Composer\Installers;

class Lava_Lite_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['package' => 'packages/{$vendor}/{$name}/', 'theme' => 'public/themes/{$name}/'];
}