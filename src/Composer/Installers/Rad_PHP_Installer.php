<?php

declare (strict_types=1);
namespace Composer\Installers;

class Rad_Php_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['bundle' => 'src/{$name}/'];
    /**
     * Format package name to CamelCase
     */
    public function inflect_package_vars(array $vars): array
    {
        $name_parts = explode('/', $vars['name']);
        foreach ($name_parts as &$value) {
            $value = strtolower($this->preg_replace('/(?<=\w)([A-Z])/', '_\1', $value));
            $value = str_replace(['-', '_'], ' ', $value);
            $value = str_replace(' ', '', ucwords($value));
        }
        $vars['name'] = implode('/', $name_parts);
        return $vars;
    }
}