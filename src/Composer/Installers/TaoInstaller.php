<?php

declare (strict_types=1);
namespace Composer\Installers;

/**
 * An installer to handle TAO extensions.
 */
class Tao_Installer extends Base_Installer
{
    public const EXTRA_TAO_EXTENSION_NAME = 'tao-extension-name';
    /** @var array<string, string> */
    protected $locations = ['extension' => '{$name}'];
    public function inflect_package_vars(array $vars): array
    {
        $extra = $this->package->get_extra();
        if (array_key_exists(self::EXTRA_TAO_EXTENSION_NAME, $extra)) {
            $vars['name'] = $extra[self::EXTRA_TAO_EXTENSION_NAME];
            return $vars;
        }
        $vars['name'] = str_replace('extension-', '', $vars['name']);
        $vars['name'] = str_replace('-', ' ', $vars['name']);
        $vars['name'] = lcfirst(str_replace(' ', '', ucwords($vars['name'])));
        return $vars;
    }
}