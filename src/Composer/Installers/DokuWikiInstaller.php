<?php

declare (strict_types=1);
namespace Composer\Installers;

class Doku_Wiki_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'lib/plugins/{$name}/', 'template' => 'lib/tpl/{$name}/'];
    /**
     * Format package name.
     *
     * For package type dokuwiki-plugin, cut off a trailing '-plugin',
     * or leading dokuwiki_ if present.
     *
     * For package type dokuwiki-template, cut off a trailing '-template' if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'dokuwiki-plugin') {
            return $this->inflect_plugin_vars($vars);
        }
        if ($vars['type'] === 'dokuwiki-template') {
            return $this->inflect_template_vars($vars);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_plugin_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/-plugin$/', '', $vars['name']);
        $vars['name'] = $this->preg_replace('/^dokuwiki_?-?/', '', $vars['name']);
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_template_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/-template$/', '', $vars['name']);
        $vars['name'] = $this->preg_replace('/^dokuwiki_?-?/', '', $vars['name']);
        return $vars;
    }
}