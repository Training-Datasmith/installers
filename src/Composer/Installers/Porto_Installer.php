<?php

declare (strict_types=1);
namespace Composer\Installers;

class Porto_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['container' => 'app/Containers/{$name}/'];
}