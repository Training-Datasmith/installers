<?php

declare (strict_types=1);
namespace Composer\Installers;

/**
 * An installer to handle MODX Evolution specifics when installing packages.
 */
class Modx_Evo_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['snippet' => 'assets/snippets/{$name}/', 'plugin' => 'assets/plugins/{$name}/', 'module' => 'assets/modules/{$name}/', 'template' => 'assets/templates/{$name}/', 'lib' => 'assets/lib/{$name}/'];
}