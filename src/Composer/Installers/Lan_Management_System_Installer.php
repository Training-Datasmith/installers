<?php

declare (strict_types=1);
namespace Composer\Installers;

class Lan_Management_System_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'plugins/{$name}/', 'template' => 'templates/{$name}/', 'document-template' => 'documents/templates/{$name}/', 'userpanel-module' => 'userpanel/modules/{$name}/'];
    /**
     * Format package name to CamelCase
     */
    public function inflect_package_vars(array $vars): array
    {
        $vars['name'] = strtolower($this->preg_replace('/(?<=\w)([A-Z])/', '_\1', $vars['name']));
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        return $vars;
    }
}