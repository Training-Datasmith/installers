<?php

declare (strict_types=1);
namespace Composer\Installers;

class Asgard_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'Modules/{$name}/', 'theme' => 'Themes/{$name}/'];
    /**
     * Format package name.
     *
     * For package type asgard-module, cut off a trailing '-plugin' if present.
     *
     * For package type asgard-theme, cut off a trailing '-theme' if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'asgard-module') {
            return $this->inflect_plugin_vars($vars);
        }
        if ($vars['type'] === 'asgard-theme') {
            return $this->inflect_theme_vars($vars);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_plugin_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/-module$/', '', $vars['name']);
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
        $vars['name'] = $this->preg_replace('/-theme$/', '', $vars['name']);
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        return $vars;
    }
}