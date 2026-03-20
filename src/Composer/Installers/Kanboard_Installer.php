<?php

declare (strict_types=1);
namespace Composer\Installers;

/**
 *
 * Installer for kanboard plugins
 *
 * kanboard.net
 *
 * Class KanboardInstaller
 * @package Composer\Installers
 */
class Kanboard_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'plugins/{$name}/'];
}