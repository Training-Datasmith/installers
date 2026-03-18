<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\OntoWikiInstaller;
use Composer\Package\Package;

/**
 * Test for the OntoWikiInstaller
 * code was taken from DokuWikiInstaller
 */
class OntoWikiInstallerTest extends TestCase
{
    /**
     * @var OntoWikiInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $package = new Package('ontowiki/some_name', '1.0.9', '1.0');
        $this->installer = new OntoWikiInstaller(
            $package,
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
                'ontowiki-extension',
                'CSVImport.ontowiki',
                'csvimport',
            ],
            [
                'ontowiki-extension',
                'csvimport',
                'csvimport',
            ],
            [
                'ontowiki-extension',
                'some_ontowiki_extension',
                'some_ontowiki_extension',
            ],
            [
                'ontowiki-extension',
                'some_ontowiki_extension.ontowiki',
                'some_ontowiki_extension',
            ],
            [
                'ontowiki-translation',
                'de-translation.ontowiki',
                'de',
            ],
            [
                'ontowiki-translation',
                'en-US-translation.ontowiki',
                'en-us',
            ],
            [
                'ontowiki-translation',
                'en-US-translation',
                'en-us',
            ],
            [
                'ontowiki-theme',
                'blue-theme.ontowiki',
                'blue',
            ],
            [
                'ontowiki-theme',
                'blue-theme',
                'blue',
            ],
        ];
    }
}
