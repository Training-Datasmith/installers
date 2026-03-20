<?php

declare (strict_types=1);
namespace Composer\Installers;

class Roundcube_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'plugins/{$name}/'];
    /**
     * Lowercase name and changes the name to a underscores
     */
    public function inflect_package_vars(array $vars): array
    {
        $vars['name'] = strtolower(str_replace('-', '_', $vars['name']));
        return $vars;
    }
}