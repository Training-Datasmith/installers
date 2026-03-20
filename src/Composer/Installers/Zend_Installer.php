<?php

declare (strict_types=1);
namespace Composer\Installers;

class Zend_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['library' => 'library/{$name}/', 'extra' => 'extras/library/{$name}/', 'module' => 'module/{$name}/'];
}