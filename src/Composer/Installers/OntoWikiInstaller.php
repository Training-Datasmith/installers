<?php

declare (strict_types=1);
namespace Composer\Installers;

class Onto_Wiki_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['extension' => 'extensions/{$name}/', 'theme' => 'extensions/themes/{$name}/', 'translation' => 'extensions/translations/{$name}/'];
    /**
     * Format package name to lower case and remove ".ontowiki" suffix
     */
    public function inflect_package_vars(array $vars): array
    {
        $vars['name'] = strtolower($vars['name']);
        $vars['name'] = $this->preg_replace('/.ontowiki$/', '', $vars['name']);
        $vars['name'] = $this->preg_replace('/-theme$/', '', $vars['name']);
        $vars['name'] = $this->preg_replace('/-translation$/', '', $vars['name']);
        return $vars;
    }
}