<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\OctoberInstaller;
use Composer\Package\Package;

class OctoberInstallerTest extends TestCase
{
    /**
     * @var OctoberInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new OctoberInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            $this->getComposer(),
            $this->getMockIO()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     */
    public function testInflectPackageVars(string $type, string $vendor, string $name, string $expectedVendor, string $expectedName): void
    {
        $this->assertEquals(
            $this->installer->inflectPackageVars([
                'vendor' => $vendor,
                'name' => $name,
                'type' => $type,
            ]),
            ['vendor' => $expectedVendor, 'name' => $expectedName, 'type' => $type]
        );
    }

    public function packageNameInflectionProvider(): array
    {
        return [
            [
                'october-plugin',
                'acme',
                'subpagelist',
                'acme',
                'subpagelist',
            ],
            [
                'october-plugin',
                'acme',
                'subpagelist-plugin',
                'acme',
                'subpagelist',
            ],
            [
                'october-plugin',
                'acme',
                'semanticoctober',
                'acme',
                'semanticoctober',
            ],
            // tests vendor name containing a hyphen
            [
                'october-plugin',
                'foo-bar-co',
                'blog',
                'foobarco',
                'blog',
            ],
            // tests that exactly one '-theme' is cut off
            [
                'october-theme',
                'acme',
                'some-theme-theme',
                'acme',
                'some-theme',
            ],
            // tests that names without '-theme' suffix stay valid
            [
                'october-theme',
                'acme',
                'someothertheme',
                'acme',
                'someothertheme',
            ],
        ];
    }
}
