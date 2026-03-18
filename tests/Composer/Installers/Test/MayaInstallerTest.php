<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\MayaInstaller;
use Composer\Package\Package;

class MayaInstallerTest extends TestCase
{
    /**
     * @var MayaInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new MayaInstaller(
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
                'maya-module',
                'user-profile',
                'UserProfile',
            ],
            [
                'maya-module',
                'maya-module',
                'Maya',
            ],
            [
                'maya-module',
                'blog',
                'Blog',
            ],
            // tests that exactly one '-module' is cut off
            [
                'maya-module',
                'some-module-module',
                'SomeModule',
            ],
        ];
    }
}
