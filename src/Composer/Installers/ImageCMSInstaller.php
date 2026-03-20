<?php

declare (strict_types=1);
namespace Composer\Installers;

class Image_Cms_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['template' => 'templates/{$name}/', 'module' => 'application/modules/{$name}/', 'library' => 'application/libraries/{$name}/'];
}