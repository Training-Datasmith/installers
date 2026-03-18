<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\SyDESInstaller;
use Composer\Package\Package;

class SyDESInstallerTest extends TestCase
{
    /**
     * @var SyDESInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new SyDESInstaller(
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
            // modules
            [
                'sydes-module',
                'name',
                'Name',
            ],
            [
                'sydes-module',
                'sample-name',
                'SampleName',
            ],
            [
                'sydes-module',
                'sydes-name',
                'Name',
            ],
            [
                'sydes-module',
                'sample-name-module',
                'SampleName',
            ],
            [
                'sydes-module',
                'sydes-sample-name-module',
                'SampleName',
            ],
            // themes
            [
                'sydes-theme',
                'some-theme-theme',
                'some-theme',
            ],
            [
                'sydes-theme',
                'sydes-sometheme',
                'sometheme',
            ],
            [
                'sydes-theme',
                'Sample-Name',
                'sample-name',
            ],
        ];
    }
}
