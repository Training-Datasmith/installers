<?php

declare (strict_types=1);
namespace Composer\Installers;

/**
 * Plugin/theme installer for shopware
 * @author Benjamin Boit
 */
class Shopware_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['backend-plugin' => 'engine/Shopware/Plugins/Local/Backend/{$name}/', 'core-plugin' => 'engine/Shopware/Plugins/Local/Core/{$name}/', 'frontend-plugin' => 'engine/Shopware/Plugins/Local/Frontend/{$name}/', 'theme' => 'templates/{$name}/', 'plugin' => 'custom/plugins/{$name}/', 'frontend-theme' => 'themes/Frontend/{$name}/'];
    /**
     * Transforms the names
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'shopware-theme') {
            return $this->correct_theme_name($vars);
        }
        return $this->correct_plugin_name($vars);
    }
    /**
     * Changes the name to a camelcased combination of vendor and name
     *
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    private function correct_plugin_name(array $vars): array
    {
        $camel_cased_name = preg_replace_callback('/(-[a-z])/', function ($matches): string {
            return strtoupper($matches[0][1]);
        }, $vars['name']);
        if (null === $camel_cased_name) {
            throw new \RuntimeException('Failed to run preg_replace_callback: ' . preg_last_error());
        }
        $vars['name'] = ucfirst($vars['vendor']) . ucfirst($camel_cased_name);
        return $vars;
    }
    /**
     * Changes the name to a underscore separated name
     *
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    private function correct_theme_name(array $vars): array
    {
        $vars['name'] = str_replace('-', '_', $vars['name']);
        return $vars;
    }
}