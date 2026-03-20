<?php

declare (strict_types=1);
namespace Composer\Installers;

class Botble_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'platform/plugins/{$name}/', 'theme' => 'platform/themes/{$name}/'];
}