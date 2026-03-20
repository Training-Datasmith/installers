<?php

declare (strict_types=1);
namespace Composer\Installers;

class Maya_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$name}/'];
    /**
     * Format package name.
     *
     * For package type maya-module, cut off a trailing '-module' if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'maya-module') {
            return $this->inflect_module_vars($vars);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_module_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/-module$/', '', $vars['name']);
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        return $vars;
    }
}