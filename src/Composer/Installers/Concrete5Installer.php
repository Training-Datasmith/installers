<?php

declare (strict_types=1);
namespace Composer\Installers;

class Concrete5Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['core' => 'concrete/', 'block' => 'application/blocks/{$name}/', 'package' => 'packages/{$name}/', 'theme' => 'application/themes/{$name}/', 'update' => 'updates/{$name}/'];
}