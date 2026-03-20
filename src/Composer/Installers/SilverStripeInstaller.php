<?php

declare (strict_types=1);
namespace Composer\Installers;

use Composer\Package\Package_Interface;
class Silver_Stripe_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['module' => '{$name}/', 'theme' => 'themes/{$name}/'];
    /**
     * Return the install path based on package type.
     *
     * Relies on built-in BaseInstaller behaviour with one exception: silverstripe/framework
     * must be installed to 'sapphire' and not 'framework' if the version is <3.0.0
     */
    public function get_install_path(Package_Interface $package, string $framework_type = ''): string
    {
        if ($package->get_name() == 'silverstripe/framework' && preg_match('/^\d+\.\d+\.\d+/', $package->get_version()) && version_compare($package->get_version(), '2.999.999') < 0) {
            return $this->template_path($this->locations['module'], ['name' => 'sapphire']);
        }
        return parent::get_install_path($package, $framework_type);
    }
}