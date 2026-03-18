<?php

namespace Composer\Installers;

class HuradInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = [
        'plugin' => 'plugins/{$name}/',
        'theme' => 'plugins/{$name}/',
    ];

    /**
     * Format package name to CamelCase
     */
    public function inflectPackageVars(array $vars): array
    {
        $nameParts = explode('/', $vars['name']);
        foreach ($nameParts as &$value) {
            $value = strtolower($this->pregReplace('/(?<=\\w)([A-Z])/', '_\\1', $value));
            $value = str_replace(['-', '_'], ' ', $value);
            $value = str_replace(' ', '', ucwords($value));
        }
        $vars['name'] = implode('/', $nameParts);
        return $vars;
    }
}
