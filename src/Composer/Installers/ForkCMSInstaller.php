<?php

declare (strict_types=1);
namespace Composer\Installers;

class Fork_Cms_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'src/Modules/{$name}/', 'theme' => 'src/Themes/{$name}/'];
    /**
     * Format package name.
     *
     * For package type fork-cms-module, cut off a trailing '-plugin' if present.
     *
     * For package type fork-cms-theme, cut off a trailing '-theme' if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'fork-cms-module') {
            return $this->inflect_module_vars($vars);
        }
        if ($vars['type'] === 'fork-cms-theme') {
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
        $vars['name'] = $this->preg_replace('/^fork-cms-|-module|ForkCMS|ForkCms|Forkcms|forkcms|Module$/', '', $vars['name']);
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        // replace hyphens with spaces
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        // make module name camelcased
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_theme_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/^fork-cms-|-theme|ForkCMS|ForkCms|Forkcms|forkcms|Theme$/', '', $vars['name']);
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        // replace hyphens with spaces
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        // make theme name camelcased
        return $vars;
    }
}