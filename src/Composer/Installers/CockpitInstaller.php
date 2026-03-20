<?php

declare (strict_types=1);
namespace Composer\Installers;

class Cockpit_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'cockpit/modules/addons/{$name}/'];
    /**
     * Format module name.
     *
     * Strip `module-` prefix from package name.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] == 'cockpit-module') {
            return $this->inflect_module_vars($vars);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    public function inflect_module_vars(array $vars): array
    {
        $vars['name'] = ucfirst($this->preg_replace('/cockpit-/i', '', $vars['name']));
        return $vars;
    }
}