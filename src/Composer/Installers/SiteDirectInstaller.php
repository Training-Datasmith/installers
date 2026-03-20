<?php

declare (strict_types=1);
namespace Composer\Installers;

class Site_Direct_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$vendor}/{$name}/', 'plugin' => 'plugins/{$vendor}/{$name}/'];
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    public function inflect_package_vars(array $vars): array
    {
        return $this->parse_vars($vars);
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function parse_vars(array $vars): array
    {
        $vars['vendor'] = strtolower($vars['vendor']) == 'sitedirect' ? 'SiteDirect' : $vars['vendor'];
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        return $vars;
    }
}