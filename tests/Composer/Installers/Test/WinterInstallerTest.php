<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\WinterInstaller;
use Composer\Package\Package;

class WinterInstallerTest extends TestCase
{
    /**
     * @var WinterInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new WinterInstaller(
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
                'winter-plugin',
                'acme',
                'subpagelist',
                'acme',
                'subpagelist',
            ],
            [
                'winter-plugin',
                'acme',
                'subpagelist-plugin',
                'acme',
                'subpagelist',
            ],
            [
                'winter-plugin',
                'acme',
                'semanticwinter',
                'acme',
                'semanticwinter',
            ],
            // tests vendor name containing a hyphen
            [
                'winter-plugin',
                'foo-bar-co',
                'blog',
                'foobarco',
                'blog',
            ],
            // tests that exactly one '-theme' is cut off
            [
                'winter-theme',
                'acme',
                'some-theme-theme',
                'acme',
                'some-theme',
            ],
            // tests that names without '-theme' suffix stay valid
            [
                'winter-theme',
                'acme',
                'someothertheme',
                'acme',
                'someothertheme',
            ],
            // tests modules
            [
                'winter-module',
                'winter',
                'wn-system-module',
                'winter',
                'system',
            ],
        ];
    }
}
