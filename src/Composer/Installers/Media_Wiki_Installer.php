<?php

declare (strict_types=1);
namespace Composer\Installers;

class Media_Wiki_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['core' => 'core/', 'extension' => 'extensions/{$name}/', 'skin' => 'skins/{$name}/'];
    /**
     * Format package name.
     *
     * For package type mediawiki-extension, cut off a trailing '-extension' if present and transform
     * to CamelCase keeping existing uppercase chars.
     *
     * For package type mediawiki-skin, cut off a trailing '-skin' if present.
     */
    public function inflect_package_vars(array $vars): array
    {
        if ($vars['type'] === 'mediawiki-extension') {
            return $this->inflect_extension_vars($vars);
        }
        if ($vars['type'] === 'mediawiki-skin') {
            return $this->inflect_skin_vars($vars);
        }
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_extension_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/-extension$/', '', $vars['name']);
        $vars['name'] = str_replace('-', ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));
        return $vars;
    }
    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflect_skin_vars(array $vars): array
    {
        $vars['name'] = $this->preg_replace('/-skin$/', '', $vars['name']);
        return $vars;
    }
}