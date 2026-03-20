<?php

declare (strict_types=1);
namespace Composer\Installers;

/**
 * Plugin/theme installer for majima
 * @author David Neustadt
 */
class Majima_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'plugins/{$name}/'];
    /**
     * Transforms the names
     *
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    public function inflect_package_vars(array $vars): array
    {
        return $this->correct_plugin_name($vars);
    }
    /**
     * Change hyphenated names to camelcase
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
        $vars['name'] = ucfirst($camel_cased_name);
        return $vars;
    }
}