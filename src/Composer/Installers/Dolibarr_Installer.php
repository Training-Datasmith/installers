<?php

declare (strict_types=1);
namespace Composer\Installers;

/**
 * Class DolibarrInstaller
 *
 * @package Composer\Installers
 * @author  Raphaël Doursenaud <rdoursenaud@gpcsolutions.fr>
 */
class Dolibarr_Installer extends Base_Installer
{
    //TODO: Add support for scripts and themes
    /** @var array<string, string> */
    protected $locations = ['module' => 'htdocs/custom/{$name}/'];
}