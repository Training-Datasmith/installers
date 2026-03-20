<?php

declare (strict_types=1);
namespace Composer\Installers;

/**
 * An installer to handle MODX specifics when installing packages.
 */
class Modx_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['extra' => 'core/packages/{$name}/'];
}