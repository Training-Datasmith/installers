<?php

declare (strict_types=1);
namespace Composer\Installers;

class Croogo_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'Plugin/{$name}/', 'theme' => 'View/Themed/{$name}/'];
    /**
     * Format package name to CamelCase
     */
    public function inflect_package_vars(array $vars): array
    {
        $vars['name'] = strtolower(str_replace(['-', '_'], ' ', $vars['name']));
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        return $vars;
    }
}