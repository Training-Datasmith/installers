<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\TastyIgniterInstaller;
use Composer\Package\Package;

class TastyIgniterInstallerTest extends TestCase
{
    /**
     * @var TastyIgniterInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new TastyIgniterInstaller(
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
            [
                'vendor' => $expectedVendor,
                'name' => $expectedName,
                'type' => $type,
            ]
        );
    }

    public function packageNameInflectionProvider(): array
    {
        return [
            [
                'tastyigniter-extension',
                'acme',
                'pages',
                'acme',
                'pages',
            ],
            [
                'tastyigniter-extension',
                'acme',
                'ti-ext-pages',
                'acme',
                'pages',
            ],
            // tests vendor name containing a hyphen
            [
                'tastyigniter-extension',
                'foo-bar-co',
                'blog',
                'foobarco',
                'blog',
            ],
            // tests that exactly one '-theme' is cut off
            [
                'tastyigniter-theme',
                'acme',
                'ti-theme-theme',
                'acme',
                'theme',
            ],
            // tests that names without '-theme' suffix stay valid
            [
                'tastyigniter-theme',
                'acme',
                'someothertheme',
                'acme',
                'someothertheme',
            ],
            [
                'tastyigniter-module',
                'tastyigniter',
                'ti-module-system',
                'tastyigniter',
                'system',
            ],
        ];
    }
}
