<?php

declare (strict_types=1);
namespace Composer\Installers;

class Agl_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'More/{$name}/'];
    /**
     * Format package name to CamelCase
     */
    public function inflect_package_vars(array $vars): array
    {
        $name = preg_replace_callback('/(?:^|_|-)(.?)/', function (array $matches) {
            return strtoupper($matches[1]);
        }, $vars['name']);
        if (null === $name) {
            throw new \RuntimeException('Failed to run preg_replace_callback: ' . preg_last_error());
        }
        $vars['name'] = $name;
        return $vars;
    }
}