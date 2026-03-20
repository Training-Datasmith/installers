<?php

declare (strict_types=1);
namespace Composer\Installers;

class Grav_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'user/plugins/{$name}/', 'theme' => 'user/themes/{$name}/'];
    /**
     * Format package name
     */
    public function inflect_package_vars(array $vars): array
    {
        $restricted_words = implode('|', array_keys($this->locations));
        $vars['name'] = strtolower($vars['name']);
        $vars['name'] = $this->preg_replace('/^(?:grav-)?(?:(?:' . $restricted_words . ')-)?(.*?)(?:-(?:' . $restricted_words . '))?$/ui', '$1', $vars['name']);
        return $vars;
    }
}