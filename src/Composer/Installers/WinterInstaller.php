<?php

declare (strict_types=1);
namespace Composer\Installers;

class Winter_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$name}/', 'plugin' => 'plugins/{$vendor}/{$name}/', 'theme' => 'themes/{$name}/'];
    /**
     * Format package name.
     *
     * For package type winter-plugin, cut off a trailing '-plugin' if present.
     *
     * For package type winter-theme, cut off a trailing '-theme' if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'winter-module') {
            return $this->inflect_module_vars($vars);
        }
        if ($vars['type'] === 'winter-plugin') {
            return $this->inflect_plugin_vars($vars);
        }
        if ($vars['type'] === 'winter-theme') {
            return $this->inflect_theme_vars($vars);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_module_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/^wn-|-module$/', '', $vars['name']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_plugin_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/^wn-|-plugin$/', '', $vars['name']);
        $vars['vendor'] = $this->preg_replace('/[^a-z0-9_]/i', '', $vars['vendor']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_theme_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/^wn-|-theme$/', '', $vars['name']);
        return $vars;
    }
}