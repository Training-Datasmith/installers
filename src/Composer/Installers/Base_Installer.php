<?php

declare (strict_types=1);
namespace Composer\Installers;

use Composer\Composer;
use Composer\IO\Io_Interface;
use Composer\Package\Package_Interface;
abstract class Base_Installer
{
    /** @var array<string, string> */
    protected $locations = [];
    /** @var Composer */
    protected $composer;
    /** @var PackageInterface */
    protected $package;
    /** @var IOInterface */
    protected $io;
    /**
     * Initializes base installer.
     */
    public function __construct(Package_Interface $package, Composer $composer, Io_Interface $io)
    {
        $this->composer = $composer;
        $this->package = $package;
        $this->io = $io;
    }
    /**
     * Return the install path based on package type.
     */
    public function get_install_path(Package_Interface $package, string $framework_type = ''): string
    {
        $type = $this->package->get_type();
        $pretty_name = $this->package->get_pretty_name();
        if (strpos($pretty_name, '/') !== false) {
            [$vendor, $name] = explode('/', $pretty_name);
        } else {
            $vendor = '';
            $name = $pretty_name;
        }
        $available_vars = $this->inflect_package_vars(compact('name', 'vendor', 'type'));
        $extra = $package->get_extra();
        if (!empty($extra['installer-name'])) {
            $available_vars['name'] = $extra['installer-name'];
        }
        $extra = $this->composer->get_package()->get_extra();
        if (!empty($extra['installer-paths'])) {
            $custom_path = $this->map_custom_install_paths($extra['installer-paths'], $pretty_name, $type, $vendor);
            if ($custom_path !== false) {
                return $this->template_path($custom_path, $available_vars);
            }
        }
        $package_type = substr($type, strlen($framework_type) + 1);
        $locations = $this->get_locations($framework_type);
        if (!isset($locations[$package_type])) {
            throw new \InvalidArgumentException(sprintf('Package type "%s" is not supported', $type));
        }
        return $this->template_path($locations[$package_type], $available_vars);
    }
    /**
     * For an installer to override to modify the vars per installer.
     *
     * @param  array<string, string> $vars This will normally receive array{name: string, vendor: string, type: string}
     * @return array<string, string>
     */
    public function inflect_package_vars(array $vars): array
    {
        return $vars;
    }
    /**
     * Gets the installer's locations
     *
     * @param  string $framework_type The framework type prefix (e.g. 'wordpress', 'drupal').
     * @return array<string, string>  Map of package sub-type => install path template.
     */
    public function get_locations(string $framework_type): array
    {
        return $this->locations;
    }
    /**
     * Replace vars in a path
     *
     * @param  array<string, string> $vars
     */
    protected function template_path(string $path, array $vars = []): string
    {
        if (strpos($path, '{') !== false) {
            preg_match_all('@\{\$([A-Za-z0-9_]*)\}@i', $path, $matches);
            foreach ($matches[1] as $var) {
                $path = str_replace('{$' . $var . '}', $vars[$var] ?? '', $path);
            }
        }
        return $path;
    }
    /**
     * Search through a passed paths array for a custom install path.
     *
     * @param  array<string, string[]|string> $paths
     * @return string|false
     */
    protected function map_custom_install_paths(array $paths, string $name, string $type, ?string $vendor = null)
    {
        foreach ($paths as $path => $names) {
            $names = (array) $names;
            if (in_array($name, $names) || in_array('type:' . $type, $names) || in_array('vendor:' . $vendor, $names)) {
                return $path;
            }
        }
        return false;
    }
    /**
     * Run preg_replace and throw on error instead of returning null.
     *
     * @param  string $pattern     PCRE pattern.
     * @param  string $replacement Replacement string.
     * @param  string $subject     Input string.
     * @return string              The string after substitution.
     * @throws \RuntimeException   If the regex fails (e.g. PREG_BACKTRACK_LIMIT_ERROR).
     */
    protected function preg_replace(string $pattern, string $replacement, string $subject): string
    {
        $result = preg_replace($pattern, $replacement, $subject);
        if (null === $result) {
            throw new \RuntimeException('Failed to run preg_replace with ' . $pattern . ': ' . preg_last_error());
        }
        return $result;
    }
}