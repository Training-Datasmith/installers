<?php

declare (strict_types=1);
namespace Composer\Installers;

class User_Frosting_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['sprinkle' => 'app/sprinkles/{$name}/'];
}