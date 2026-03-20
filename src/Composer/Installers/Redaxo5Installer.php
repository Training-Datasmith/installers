<?php

declare (strict_types=1);
namespace Composer\Installers;

class Redaxo5Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['addon' => 'redaxo/src/addons/{$name}/', 'bestyle-plugin' => 'redaxo/src/addons/be_style/plugins/{$name}/'];
}