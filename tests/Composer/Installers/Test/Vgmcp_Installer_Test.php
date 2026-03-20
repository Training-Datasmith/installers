<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\VgmcpInstaller;
use Composer\Package\Package;

class VgmcpInstallerTest extends TestCase
{
    /**
     * @var VgmcpInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new VgmcpInstaller(
            new Package('NyanCat', '4.2', '4.2'),
            $this->getComposer(),
            $this->getMockIO()
        );
    }

    /**
     * @dataProvider packageNameInflectionProvider
     */
    public function testInflectPackageVars(string $type, string $name, string $expected): void
    {
        $this->assertEquals(
            ['name' => $expected, 'type' => $type],
            $this->installer->inflectPackageVars(['name' => $name, 'type' => $type])
        );
    }

    public function packageNameInflectionProvider(): array
    {
        return [
            // Should keep bundle name StudlyCase
            [
                'vgmcp-bundle',
                'user-profile',
                'UserProfile',
            ],
            [
                'vgmcp-bundle',
                'vgmcp-bundle',
                'Vgmcp',
            ],
            [
                'vgmcp-bundle',
                'blog',
                'Blog',
            ],
            // tests that exactly one '-bundle' is cut off
            [
                'vgmcp-bundle',
                'some-bundle-bundle',
                'SomeBundle',
            ],
            // tests that exactly one '-theme' is cut off
            [
                'vgmcp-theme',
                'some-theme-theme',
                'SomeTheme',
            ],
            // tests that names without '-theme' suffix stay valid
            [
                'vgmcp-theme',
                'someothertheme',
                'Someothertheme',
            ],
            // Should keep theme name StudlyCase
            [
                'vgmcp-theme',
                'adminlte-advanced',
                'AdminlteAdvanced',
            ],
        ];
    }
}
