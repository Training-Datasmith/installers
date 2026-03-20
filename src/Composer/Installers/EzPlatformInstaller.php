<?php

declare (strict_types=1);
namespace Composer\Installers;

class Ez_Platform_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['meta-assets' => 'web/assets/ezplatform/', 'assets' => 'web/assets/ezplatform/{$name}/'];
}