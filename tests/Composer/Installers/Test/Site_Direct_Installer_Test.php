<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\SiteDirectInstaller;
use Composer\Package\Package;

class SiteDirectInstallerTest extends TestCase
{
    /** @var SiteDirectInstaller */
    protected $installer;

    /** @var Package */
    private $package;

    public function setUp(): void
    {
        $this->package = new Package('sitedirect/some_name', '1.0.9', '1.0');
        $this->installer = new SiteDirectInstaller(
            $this->package,
            $this->getComposer(),
            $this->getMockIO()
        );
    }

    /**
     * @dataProvider dataProvider
     * @param array{name: string, vendor: string, type: string} $data
     * @param array{name: string, vendor: string, type: string} $expected
     */
    public function testInflectPackageVars(array $data, array $expected): void
    {
        $result = $this->installer->inflectPackageVars($data);
        $this->assertEquals($result, $expected);
    }

    /**
     * @dataProvider dataProvider
     * @param array{name: string, vendor: string, type: string} $data
     * @param array{name: string, vendor: string, type: string} $expected
     */
    public function testInstallPath(array $data, array $expected): void
    {
        $result = $this->installer->inflectPackageVars($data);
        $path = $this->createPackage($data);

        // use $result to get the proper capitalization for the vendor path
        $expectedPath = "modules/{$result['vendor']}/{$result['name']}/";
        $notExpectedPath = "modules/{$data['vendor']}/{$data['name']}/";
        $this->assertEquals($expectedPath, $path);
        $this->assertNotEquals($notExpectedPath, $path);
    }

    /**
     * @param string[] $data
     * @return string
     */
    private function createPackage(array $data): string
    {
        $fullName = "{$data['vendor']}/{$data['name']}";

        $package = new Package($fullName, '1.0', '1.0');
        $package->setType('sitedirect-module');
        $installer = new SiteDirectInstaller($package, $this->getComposer(), $this->getMockIO());

        return $installer->getInstallPath($package, 'sitedirect');
    }

    public function dataProvider(): array
    {
        return [
            [
                'data' => [
                    'name' => 'kernel',
                    'vendor' => 'sitedirect',
                    'type' => 'sitedirect-module',
                ],
                'expected' => [
                    'name' => 'Kernel',
                    'vendor' => 'SiteDirect',
                    'type' => 'sitedirect-module',
                ],
            ],
            [
                'data' => [
                    'name' => 'that_guy',
                    'vendor' => 'whatGuy',
                    'type' => 'sitedirect-module',
                ],
                'expected' => [
                    'name' => 'ThatGuy',
                    'vendor' => 'whatGuy',
                    'type' => 'sitedirect-module',
                ],
            ],
            [
                'data' => [
                    'name' => 'checkout',
                    'vendor' => 'someVendor',
                    'type' => 'sitedirect-plugin',
                ],
                'expected' => [
                    'name' => 'Checkout',
                    'vendor' => 'someVendor',
                    'type' => 'sitedirect-plugin',
                ],
            ],
            [
                'data' => [
                    'name' => 'checkout',
                    'vendor' => 'siteDirect',
                    'type' => 'sitedirect-plugin',
                ],
                'expected' => [
                    'name' => 'Checkout',
                    'vendor' => 'SiteDirect',
                    'type' => 'sitedirect-plugin',
                ],
            ],
        ];
    }
}
