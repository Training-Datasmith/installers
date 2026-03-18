<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\AsgardInstaller;
use Composer\Package\Package;

class AsgardInstallerTest extends TestCase
{
    /**
     * @var AsgardInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new AsgardInstaller(
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
            // Should keep module name StudlyCase
            [
                'asgard-module',
                'user-profile',
                'UserProfile',
            ],
            [
                'asgard-module',
                'asgard-module',
                'Asgard',
            ],
            [
                'asgard-module',
                'blog',
                'Blog',
            ],
            // tests that exactly one '-module' is cut off
            [
                'asgard-module',
                'some-module-module',
                'SomeModule',
            ],
            // tests that exactly one '-theme' is cut off
            [
                'asgard-theme',
                'some-theme-theme',
                'SomeTheme',
            ],
            // tests that names without '-theme' suffix stay valid
            [
                'asgard-theme',
                'someothertheme',
                'Someothertheme',
            ],
            // Should keep theme name StudlyCase
            [
                'asgard-theme',
                'adminlte-advanced',
                'AdminlteAdvanced',
            ],
        ];
    }
}
