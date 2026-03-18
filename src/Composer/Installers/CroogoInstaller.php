<?php

declare(strict_types=1);

namespace Composer\Installers;

class CroogoInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin' => 'Plugin/{$name}/',
        'theme' => 'View/Themed/{$name}/',
    ];

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars(array $vars): array
    {
        $vars['name'] = strtolower(str_replace(['-', '_'], ' ', $vars['name']));
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }
}
