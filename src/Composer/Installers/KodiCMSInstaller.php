<?php

declare (strict_types=1);
namespace Composer\Installers;

class Kodi_Cms_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'cms/plugins/{$name}/', 'media' => 'cms/media/vendor/{$name}/'];
}