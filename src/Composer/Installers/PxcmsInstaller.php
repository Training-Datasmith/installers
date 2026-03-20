<?php

declare (strict_types=1);
namespace Composer\Installers;

class Pxcms_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'app/Modules/{$name}/', 'theme' => 'themes/{$name}/'];
    /**
     * Format package name.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'pxcms-module') {
            return $this->inflect_module_vars($vars);
        }
        if ($vars['type'] === 'pxcms-theme') {
            return $this->inflect_theme_vars($vars);
        }
        return $vars;
    }
    /**
     * For package type pxcms-module, cut off a trailing '-plugin' if present.
     *
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_module_vars(array $vars): array
    {
        $vars['name'] = str_replace('pxcms-', '', $vars['name']);
        // strip out pxcms- just incase (legacy)
        $vars['name'] = str_replace('module-', '', $vars['name']);
        // strip out module-
        $vars['name'] = $this->preg_replace('/-module$/', '', $vars['name']);
        // strip out -module
        $vars['name'] = str_replace('-', '_', $vars['name']);
        // make -'s be _'s
        $vars['name'] = ucwords($vars['name']);
        // make module name camelcased
        return $vars;
    }
    /**
     * For package type pxcms-module, cut off a trailing '-plugin' if present.
     *
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_theme_vars(array $vars): array
    {
        $vars['name'] = str_replace('pxcms-', '', $vars['name']);
        // strip out pxcms- just incase (legacy)
        $vars['name'] = str_replace('theme-', '', $vars['name']);
        // strip out theme-
        $vars['name'] = $this->preg_replace('/-theme$/', '', $vars['name']);
        // strip out -theme
        $vars['name'] = str_replace('-', '_', $vars['name']);
        // make -'s be _'s
        $vars['name'] = ucwords($vars['name']);
        // make module name camelcased
        return $vars;
    }
}