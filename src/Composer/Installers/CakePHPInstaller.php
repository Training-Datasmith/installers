<?php

declare (strict_types=1);
namespace Composer\Installers;

use Composer\Semver\Constraint\Constraint;
class Cake_Php_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'Plugin/{$name}/'];
    /**
     * Format package name to CamelCase
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($this->matches_cake_version('>=', '3.0.0')) {
            return $vars;
        }
        $name_parts = explode('/', $vars['name']);
        foreach ($name_parts as &$value) {
            $value = strtolower($this->preg_replace('/(?<=\w)([A-Z])/', '_\1', $value));
            $value = str_replace(['-', '_'], ' ', $value);
            $value = str_replace(' ', '', ucwords($value));
        }
        $vars['name'] = implode('/', $name_parts);
        return $vars;
    }
    /**
     * Change the default plugin location when cakephp >= 3.0
     */
    public function get_locations(string $framework_type): array
    {
        if ($this->matches_cake_version('>=', '3.0.0')) {
            $this->locations['plugin'] = $this->composer->get_config()->get('vendor-dir') . '/{$vendor}/{$name}/';
        }
        return $this->locations;
    }
    /**
     * Check if CakePHP version matches against a version
     *
     * @phpstan-param '='|'=='|'<'|'<='|'>'|'>='|'<>'|'!=' $matcher
     */
    protected function matches_cake_version(string $matcher, string $version): bool
    {
        $repository_manager = $this->composer->get_repository_manager();
        /** @phpstan-ignore-next-line */
        if (!$repository_manager) {
            return false;
        }
        $repos = $repository_manager->get_local_repository();
        /** @phpstan-ignore-next-line */
        if (!$repos) {
            return false;
        }
        return $repos->find_package('cakephp/cakephp', new Constraint($matcher, $version)) !== null;
    }
}