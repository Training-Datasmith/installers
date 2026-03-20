<?php

declare (strict_types=1);
namespace Composer\Installers;

use Composer\Package\Package_Interface;
class Oxid_Installer extends Base_Installer
{
    public const VENDOR_PATTERN = '/^modules\/(?P<vendor>.+)\/.+/';
    /** @var array<string, string> */
    protected $locations = ['module' => 'modules/{$name}/', 'theme' => 'application/views/{$name}/', 'out' => 'out/{$name}/'];
    public function get_install_path(Package_Interface $package, string $framework_type = ''): string
    {
        $install_path = parent::get_install_path($package, $framework_type);
        $type = $this->package->get_type();
        if ($type === 'oxid-module') {
            $this->prepare_vendor_directory($install_path);
        }
        return $install_path;
    }
    /**
     * Makes sure there is a vendormetadata.php file inside
     * the vendor folder if there is a vendor folder.
     */
    protected function prepare_vendor_directory(string $install_path): void
    {
        $matches = '';
        $has_vendor_directory = preg_match(self::VENDOR_PATTERN, $install_path, $matches);
        if (!$has_vendor_directory) {
            return;
        }
        $vendor_directory = $matches['vendor'];
        $vendor_path = getcwd() . '/modules/' . $vendor_directory;
        if (!file_exists($vendor_path)) {
            mkdir($vendor_path, 0755, true);
        }
        $vendor_meta_data_path = $vendor_path . '/vendormetadata.php';
        touch($vendor_meta_data_path);
    }
}