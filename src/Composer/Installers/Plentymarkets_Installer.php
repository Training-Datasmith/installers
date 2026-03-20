<?php

declare (strict_types=1);
namespace Composer\Installers;

class Plentymarkets_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => '{$name}/'];
    /**
     * Remove hyphen, "plugin" and format to camelcase
     */
    public function inflect_package_vars(array $vars): array
    {
        $name_bits = explode('-', $vars['name']);
        foreach ($name_bits as $key => $name) {
            $name_bits[$key] = ucfirst($name);
            if (strcasecmp($name, 'Plugin') == 0) {
                unset($name_bits[$key]);
            }
        }
        $vars['name'] = implode('', $name_bits);
        return $vars;
    }
}