<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Config;
use Composer\Installers\CakePHPInstaller;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\Version\VersionParser;
use Composer\Repository\InstalledArrayRepository;
use Composer\Repository\RepositoryManager;
use Composer\Util\HttpDownloader;

class CakePHPInstallerTest extends TestCase
{
    /**
     * @var Composer
     */
    private $composer;
    /**
     * @var Package
     */
    private $package;

    public function setUp(): void
    {
        $this->package = new Package('CamelCased', '1.0', '1.0');
        $this->composer = $this->getComposer();
    }

    public function testInflectPackageVars(): void
    {
        $installer = new CakePHPInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'CamelCased']);
        $this->assertEquals($result, ['name' => 'CamelCased']);

        $installer = new CakePHPInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'with-dash']);
        $this->assertEquals($result, ['name' => 'WithDash']);

        $installer = new CakePHPInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'with_underscore']);
        $this->assertEquals($result, ['name' => 'WithUnderscore']);

        $installer = new CakePHPInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'cake/acl']);
        $this->assertEquals($result, ['name' => 'Cake/Acl']);

        $installer = new CakePHPInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'cake/debug-kit']);
        $this->assertEquals($result, ['name' => 'Cake/DebugKit']);
    }

    /**
     * Test getLocations returning appropriate values based on CakePHP version
     */
    public function testGetLocations(): void
    {
        $package = new RootPackage('CamelCased', '1.0', '1.0');
        $composer = $this->composer;

        $io = $this->getMockBuilder(IOInterface::class)->getMock();
        $config = $this->getMockBuilder(Config::class)->getMock();

        // Simultaneous support for Composer 1 and 2
        $constructorArg3 = null;
        $reflectorClass = new \ReflectionClass(RepositoryManager::class);
        $reflMethod = $reflectorClass->getConstructor();
        if ($reflMethod && $reflMethod->getNumberOfRequiredParameters() == 3) {
            $constructorArg3 = $this->getMockBuilder(HttpDownloader::class)->disableOriginalConstructor()->getMock();
        }
        $rm = new RepositoryManager(
            $io,
            $config,
            /** @phpstan-ignore-next-line */
            $constructorArg3
        );
        $composer->setRepositoryManager($rm);
        $installer = new CakePHPInstaller($package, $composer, $this->getMockIO());

        // 2.0 < cakephp < 3.0
        $this->setCakephpVersion($rm, '2.0.0');
        $result = $installer->getLocations('cakephp');
        $this->assertStringContainsString('Plugin/', $result['plugin']);

        $this->setCakephpVersion($rm, '2.5.9');
        $result = $installer->getLocations('cakephp');
        $this->assertStringContainsString('Plugin/', $result['plugin']);

        $this->setCakephpVersion($rm, '~2.5');
        $result = $installer->getLocations('cakephp');
        $this->assertStringContainsString('Plugin/', $result['plugin']);

        $this->setCakephpVersion($rm, '>=2.5');
        $result = $installer->getLocations('cakephp');
        $this->assertStringContainsString('Plugin/', $result['plugin']);

        // cakephp >= 3.0
        $this->setCakephpVersion($rm, '3.0.*-dev');
        $result = $installer->getLocations('cakephp');
        $this->assertStringContainsString('vendor/{$vendor}/{$name}/', $result['plugin']);

        $this->setCakephpVersion($rm, '~8.8');
        $result = $installer->getLocations('cakephp');
        $this->assertStringContainsString('vendor/{$vendor}/{$name}/', $result['plugin']);
    }

    protected function setCakephpVersion(RepositoryManager $rm, string $version): void
    {
        $parser = new VersionParser();
        list(, $version) = explode(' ', $parser->parseConstraints($version));
        $installed = new InstalledArrayRepository();
        $package = new Package('cakephp/cakephp', $version, $version);
        $installed->addPackage($package);
        $rm->setLocalRepository($installed);
    }
}
