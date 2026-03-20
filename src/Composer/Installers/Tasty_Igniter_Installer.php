<?php

declare (strict_types=1);
namespace Composer\Installers;

class Tasty_Igniter_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => 'app/{$name}/', 'extension' => 'extensions/{$vendor}/{$name}/', 'theme' => 'themes/{$name}/'];
    /**
     * Format package name.
     *
     * Cut off leading 'ti-ext-' or 'ti-theme-' if present.
     * Strip vendor name of characters that is not alphanumeric or an underscore
     *
     */
    public function inflect_package_vars(array $vars): array
    {
        $extra = $this->package->get_extra();
        if ($vars['type'] === 'tastyigniter-module') {
            return $this->inflect_module_vars($vars);
        }
        if ($vars['type'] === 'tastyigniter-extension') {
            return $this->inflect_extension_vars($vars, $extra);
        }
        if ($vars['type'] === 'tastyigniter-theme') {
            return $this->inflect_theme_vars($vars, $extra);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_module_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/^ti-module-/', '', $vars['name']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @param array<string, mixed> $extra
     * @return array<string, string>
     */
    protected function inflect_extension_vars(array $vars, array $extra): array
    {
        if (!empty($extra['tastyigniter-extension']['code'])) {
            $parts = explode('.', $extra['tastyigniter-extension']['code']);
            $vars['vendor'] = $parts[0];
            $vars['name'] = $parts[1] ?? '';
        }
        $vars['vendor'] = $this->preg_replace('/[^a-z0-9_]/i', '', $vars['vendor']);
        $vars['name'] = $this->preg_replace('/^ti-ext-/', '', $vars['name']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @param array<string, mixed> $extra
     * @return array<string, string>
     */
    protected function inflect_theme_vars(array $vars, array $extra): array
    {
        if (!empty($extra['tastyigniter-theme']['code'])) {
            $vars['name'] = $extra['tastyigniter-theme']['code'];
        }
        $vars['name'] = $this->preg_replace('/^ti-theme-/', '', $vars['name']);
        return $vars;
    }
}