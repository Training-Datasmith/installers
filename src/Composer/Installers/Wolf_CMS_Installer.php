<?php

declare (strict_types=1);
namespace Composer\Installers;

class Wolf_Cms_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'wolf/plugins/{$name}/'];
}