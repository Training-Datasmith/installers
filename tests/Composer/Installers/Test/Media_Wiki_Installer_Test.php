<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\MediaWikiInstaller;
use Composer\Package\Package;

class MediaWikiInstallerTest extends TestCase
{
    /**
     * @var MediaWikiInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new MediaWikiInstaller(
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
                'mediawiki-extension',
                'sub-page-list',
                'SubPageList',
            ],
            [
                'mediawiki-extension',
                'sub-page-list-extension',
                'SubPageList',
            ],
            [
                'mediawiki-extension',
                'semantic-mediawiki',
                'SemanticMediawiki',
            ],
            // tests that exactly one '-skin' is cut off, and that skins do not get ucwords treatment like extensions
            [
                'mediawiki-skin',
                'some-skin-skin',
                'some-skin',
            ],
            // tests that names without '-skin' suffix stay valid
            [
                'mediawiki-skin',
                'someotherskin',
                'someotherskin',
            ],
        ];
    }
}
