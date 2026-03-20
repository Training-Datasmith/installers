<?php

declare (strict_types=1);
namespace Composer\Installers;

class Civi_Crm_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['ext' => 'ext/{$name}/'];
}