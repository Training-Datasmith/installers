<?php

declare (strict_types=1);
namespace Composer\Installers;

class Mautic_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'plugins/{$name}/', 'theme' => 'themes/{$name}/', 'core' => 'app/'];
    private function get_directory_name(): string
    {
        $extra = $this->package->get_extra();
        if (!empty($extra['install-directory-name'])) {
            return $extra['install-directory-name'];
        }
        return $this->to_camel_case($this->package->get_pretty_name());
    }
    private function to_camel_case(string $package_name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', basename($package_name))));
    }
    /**
     * Format package name of mautic-plugins to CamelCase
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] == 'mautic-plugin' || $vars['type'] == 'mautic-theme') {
            $directory_name = $this->get_directory_name();
            $vars['name'] = $directory_name;
        }
        return $vars;
    }
}