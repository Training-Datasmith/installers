<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\YawikInstaller;
use Composer\Package\Package;

/**
 * Class YawikInstallerTest
 *
 * @package Composer\Installers\Test
 */
class YawikInstallerTest extends TestCase
{
    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var Package
     */
    private $package;

    /**
     * setUp
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->package = new Package('YawikCompanyRegistration', '1.0', '1.0');
        $this->composer = new Composer();
    }

    /**
     * @dataProvider packageNameProvider
     */
    public function testInflectPackageVars(string $input): void
    {
        $installer = new YawikInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => $input]);
        $this->assertEquals($result, ['name' => 'YawikCompanyRegistration']);
    }

    public function packageNameProvider(): array
    {
        return [
            ['yawik-company-registration'],
            ['yawik_company_registration'],
            ['YawikCompanyRegistration'],
        ];
    }
}
