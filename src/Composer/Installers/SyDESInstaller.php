<?php

declare (strict_types=1);
namespace Composer\Installers;

class Sy_Des_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'app/modules/{$name}/', 'theme' => 'themes/{$name}/'];
    /**
     * Format module name.
     *
     * Strip `sydes-` prefix and a trailing '-theme' or '-module' from package name if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] == 'sydes-module') {
            return $this->inflect_module_vars($vars);
        }
        if ($vars['type'] === 'sydes-theme') {
            return $this->inflect_theme_vars($vars);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    public function inflect_module_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/(^sydes-|-module$)/i', '', $vars['name']);
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_theme_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/(^sydes-|-theme$)/', '', $vars['name']);
        $vars['name'] = strtolower($vars['name']);
        return $vars;
    }
}