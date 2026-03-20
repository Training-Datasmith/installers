<?php

declare (strict_types=1);
namespace Composer\Installers;

class Vgmcp_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['bundle' => 'src/{$vendor}/{$name}/', 'theme' => 'themes/{$name}/'];
    /**
     * Format package name.
     *
     * For package type vgmcp-bundle, cut off a trailing '-bundle' if present.
     *
     * For package type vgmcp-theme, cut off a trailing '-theme' if present.
     *
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'vgmcp-bundle') {
            return $this->inflect_plugin_vars($vars);
        }
        if ($vars['type'] === 'vgmcp-theme') {
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
        $vars['name'] = $this->preg_replace('/-bundle$/', '', $vars['name']);
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