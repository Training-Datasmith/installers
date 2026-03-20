<?php

declare (strict_types=1);
namespace Composer\Installers;

use Composer\Composer;
use Composer\Installer\Binary_Installer;
use Composer\Installer\Library_Installer;
use Composer\IO\Io_Interface;
use Composer\Package\Package;
use Composer\Package\Package_Interface;
use Composer\Repository\Installed_Repository_Interface;
use Composer\Util\Filesystem;
use React\Promise\Promise_Interface;
class Installer extends Library_Installer
{
    /**
     * Package types to installer class map
     *
     * @var array<string, string>
     */
    private $supported_types = ['akaunting' => 'AkauntingInstaller', 'asgard' => 'AsgardInstaller', 'attogram' => 'AttogramInstaller', 'agl' => 'AglInstaller', 'annotatecms' => 'AnnotateCmsInstaller', 'bitrix' => 'BitrixInstaller', 'botble' => 'BotbleInstaller', 'bonefish' => 'BonefishInstaller', 'cakephp' => 'CakePHPInstaller', 'chef' => 'ChefInstaller', 'civicrm' => 'CiviCrmInstaller', 'ccframework' => 'ClanCatsFrameworkInstaller', 'cockpit' => 'CockpitInstaller', 'codeigniter' => 'CodeIgniterInstaller', 'concrete5' => 'Concrete5Installer', 'concretecms' => 'ConcreteCMSInstaller', 'croogo' => 'CroogoInstaller', 'dframe' => 'DframeInstaller', 'dokuwiki' => 'DokuWikiInstaller', 'dolibarr' => 'DolibarrInstaller', 'decibel' => 'DecibelInstaller', 'drupal' => 'DrupalInstaller', 'elgg' => 'ElggInstaller', 'eliasis' => 'EliasisInstaller', 'ee3' => 'ExpressionEngineInstaller', 'ee2' => 'ExpressionEngineInstaller', 'ezplatform' => 'EzPlatformInstaller', 'fork' => 'ForkCMSInstaller', 'fuel' => 'FuelInstaller', 'fuelphp' => 'FuelphpInstaller', 'grav' => 'GravInstaller', 'hurad' => 'HuradInstaller', 'tastyigniter' => 'TastyIgniterInstaller', 'imagecms' => 'ImageCMSInstaller', 'itop' => 'ItopInstaller', 'kanboard' => 'KanboardInstaller', 'known' => 'KnownInstaller', 'kodicms' => 'KodiCMSInstaller', 'kohana' => 'KohanaInstaller', 'lms' => 'LanManagementSystemInstaller', 'laravel' => 'LaravelInstaller', 'lavalite' => 'LavaLiteInstaller', 'lithium' => 'LithiumInstaller', 'magento' => 'MagentoInstaller', 'majima' => 'MajimaInstaller', 'mantisbt' => 'MantisBTInstaller', 'mako' => 'MakoInstaller', 'matomo' => 'MatomoInstaller', 'maya' => 'MayaInstaller', 'mautic' => 'MauticInstaller', 'mediawiki' => 'MediaWikiInstaller', 'miaoxing' => 'MiaoxingInstaller', 'microweber' => 'MicroweberInstaller', 'modulework' => 'MODULEWorkInstaller', 'modx' => 'ModxInstaller', 'modxevo' => 'MODXEvoInstaller', 'moodle' => 'MoodleInstaller', 'october' => 'OctoberInstaller', 'ontowiki' => 'OntoWikiInstaller', 'oxid' => 'OxidInstaller', 'osclass' => 'OsclassInstaller', 'pxcms' => 'PxcmsInstaller', 'phpbb' => 'PhpBBInstaller', 'piwik' => 'PiwikInstaller', 'plentymarkets' => 'PlentymarketsInstaller', 'ppi' => 'PPIInstaller', 'puppet' => 'PuppetInstaller', 'radphp' => 'RadPHPInstaller', 'phifty' => 'PhiftyInstaller', 'porto' => 'PortoInstaller', 'processwire' => 'ProcessWireInstaller', 'quicksilver' => 'PantheonInstaller', 'redaxo' => 'RedaxoInstaller', 'redaxo5' => 'Redaxo5Installer', 'reindex' => 'ReIndexInstaller', 'roundcube' => 'RoundcubeInstaller', 'shopware' => 'ShopwareInstaller', 'sitedirect' => 'SiteDirectInstaller', 'silverstripe' => 'SilverStripeInstaller', 'smf' => 'SMFInstaller', 'starbug' => 'StarbugInstaller', 'sydes' => 'SyDESInstaller', 'sylius' => 'SyliusInstaller', 'tao' => 'TaoInstaller', 'thelia' => 'TheliaInstaller', 'tusk' => 'TuskInstaller', 'userfrosting' => 'UserFrostingInstaller', 'vanilla' => 'VanillaInstaller', 'whmcs' => 'WHMCSInstaller', 'winter' => 'WinterInstaller', 'wolfcms' => 'WolfCMSInstaller', 'wordpress' => 'WordPressInstaller', 'yawik' => 'YawikInstaller', 'zend' => 'ZendInstaller', 'zikula' => 'ZikulaInstaller', 'prestashop' => 'PrestashopInstaller'];
    /**
     * Disables installers specified in main composer extra installer-disable
     * list
     */
    public function __construct(Io_Interface $io, Composer $composer, string $type = 'library', ?Filesystem $filesystem = null, ?Binary_Installer $binary_installer = null)
    {
        parent::__construct($io, $composer, $type, $filesystem, $binary_installer);
        $this->remove_disabled_installers();
    }
    /**
     * {@inheritDoc}
     */
    public function get_install_path(Package_Interface $package)
    {
        $type = $package->get_type();
        $framework_type = $this->find_framework_type($type);
        if ($framework_type === false) {
            throw new \InvalidArgumentException('Sorry the package type of this package is not yet supported.');
        }
        $class = 'Composer\Installers\\' . $this->supported_types[$framework_type];
        /**
         * @var BaseInstaller
         */
        $installer = new $class($package, $this->composer, $this->get_io());
        $path = $installer->get_install_path($package, $framework_type);
        if (!$this->filesystem->is_absolute_path($path)) {
            return getcwd() . '/' . $path;
        }
        return $path;
    }
    public function uninstall(Installed_Repository_Interface $repo, Package_Interface $package)
    {
        $install_path = $this->get_package_base_path($package);
        $io = $this->io;
        $output_status = function () use ($io, $install_path): void {
            $io->write(sprintf('Deleting %s - %s', $install_path, !file_exists($install_path) ? '<comment>deleted</comment>' : '<error>not deleted</error>'));
        };
        $promise = parent::uninstall($repo, $package);
        // Composer v2 might return a promise here
        if ($promise instanceof Promise_Interface) {
            return $promise->then($output_status);
        }
        // If not, execute the code right away as parent::uninstall executed synchronously (composer v1, or v2 without async)
        $output_status();
        return null;
    }
    /**
     * {@inheritDoc}
     *
     * @param string $packageType
     */
    public function supports($package_type)
    {
        $framework_type = $this->find_framework_type($package_type);
        if ($framework_type === false) {
            return false;
        }
        $location_pattern = $this->get_location_pattern($framework_type);
        return preg_match('#' . $framework_type . '-' . $location_pattern . '#', $package_type, $matches) === 1;
    }
    /**
     * Finds a supported framework type if it exists and returns it
     *
     * @return string|false
     */
    protected function find_framework_type(string $type)
    {
        krsort($this->supported_types);
        foreach ($this->supported_types as $key => $val) {
            if ($key === substr($type, 0, strlen($key))) {
                return substr($type, 0, strlen($key));
            }
        }
        return false;
    }
    /**
     * Get the second part of the regular expression to check for support of a
     * package type
     */
    protected function get_location_pattern(string $framework_type): string
    {
        $pattern = null;
        if (!empty($this->supported_types[$framework_type])) {
            $framework_class = 'Composer\Installers\\' . $this->supported_types[$framework_type];
            /** @var BaseInstaller $framework */
            $framework = new $framework_class(new Package('dummy/pkg', '1.0.0.0', '1.0.0'), $this->composer, $this->get_io());
            $locations = array_keys($framework->get_locations($framework_type));
            if ($locations) {
                $pattern = '(' . implode('|', $locations) . ')';
            }
        }
        return $pattern ?: '(\w+)';
    }
    private function get_io(): Io_Interface
    {
        return $this->io;
    }
    /**
     * Look for installers set to be disabled in composer's extra config and
     * remove them from the list of supported installers.
     *
     * Globals:
     *  - true, "all", and "*" - disable all installers.
     *  - false - enable all installers (useful with
     *     wikimedia/composer-merge-plugin or similar)
     */
    protected function remove_disabled_installers(): void
    {
        $extra = $this->composer->get_package()->get_extra();
        if (!isset($extra['installer-disable']) || $extra['installer-disable'] === false) {
            // No installers are disabled
            return;
        }
        // Get installers to disable
        $disable = $extra['installer-disable'];
        // Ensure $disabled is an array
        if (!is_array($disable)) {
            $disable = [$disable];
        }
        // Check which installers should be disabled
        $all = [true, 'all', '*'];
        $intersect = array_intersect($all, $disable);
        if (!empty($intersect)) {
            // Disable all installers
            $this->supported_types = [];
            return;
        }
        // Disable specified installers
        foreach ($disable as $installer) {
            if (is_string($installer) && key_exists($installer, $this->supported_types)) {
                unset($this->supported_types[$installer]);
            }
        }
    }
}