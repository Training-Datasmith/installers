<?php

namespace Composer\Installers;

use Composer\DependencyResolver\Pool;

class MantisBTInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin' => 'plugins/{$name}/',
    ];

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars(array $vars): array
    {
        $vars['name'] = strtolower($this->pregReplace('/(?<=\\w)([A-Z])/', '_\\1', $vars['name']));
        $vars['name'] = str_replace(['-', '_'], ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }
}
