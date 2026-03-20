<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\DokuWikiInstaller;
use Composer\Package\Package;

class DokuWikiInstallerTest extends TestCase
{
    /**
     * @var DokuWikiInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new DokuWikiInstaller(
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
            $this->installer->inflectPackageVars(['name' => $name, 'type' => $type]),
            ['name' => $expected, 'type' => $type]
        );
    }

    public function packageNameInflectionProvider(): array
    {
        return [
            [
                'dokuwiki-plugin',
                'dokuwiki-test-plugin',
                'test',
            ],
            [
                'dokuwiki-plugin',
                'test-plugin',
                'test',
            ],
            [
                'dokuwiki-plugin',
                'dokuwiki_test',
                'test',
            ],
            [
                'dokuwiki-plugin',
                'test',
                'test',
            ],
            [
                'dokuwiki-plugin',
                'test-template',
                'test-template',
            ],
            [
                'dokuwiki-template',
                'dokuwiki-test-template',
                'test',
            ],
            [
                'dokuwiki-template',
                'test-template',
                'test',
            ],
            [
                'dokuwiki-template',
                'dokuwiki_test',
                'test',
            ],
            [
                'dokuwiki-template',
                'test',
                'test',
            ],
            [
                'dokuwiki-template',
                'test-plugin',
                'test-plugin',
            ],
        ];
    }
}
