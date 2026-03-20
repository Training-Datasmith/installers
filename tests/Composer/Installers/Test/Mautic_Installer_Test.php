<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\MauticInstaller;
use Composer\Package\Package;

class MauticInstallerTest extends TestCase
{
    /**
     * @var Composer
     */
    protected $composer;

    public function setUp(): void
    {
        $this->composer = new Composer();
    }

    /**
     * @param string[] $vars
     * @param string[] $expectedVars
     *
     * @covers ::inflectPackageVars
     *
     * @dataProvider expectedInflectionResultsProvider
     */
    public function testInflectPackageVars(array $vars, array $expectedVars): void
    {
        $package = new Package($vars['name'], '1.0.0', '1.0.0');
        $package->setType($vars['type']);
        if (isset($vars['extra'])) {
            $package->setExtra((array) $vars['extra']);
        }

        $installer = new MauticInstaller(
            $package,
            $this->composer,
            $this->getMockIO()
        );

        $actual = $installer->inflectPackageVars($vars);
        $this->assertEquals($actual, $expectedVars);
    }

    /**
     * Provides various parameters for packages and the expected result after
     * inflection
     *
     * @return array
     */
    public function expectedInflectionResultsProvider(): array
    {
        return [
            //check bitrix-dir is correct
            [
                [
                    'name' => 'mautic/grapes-js-builder-bundle',
                    'type' => 'mautic-plugin',
                ],
                [
                    'name' => 'GrapesJsBuilderBundle',
                    'type' => 'mautic-plugin',
                ],
            ],
            // Check if composer renames the name based on the given
            // installation directory
            [
                [
                    'name' => 'mautic/grapes-js-builder-bundle',
                    'type' => 'mautic-plugin',
                    'extra' => [
                        'install-directory-name' => 'GrapesJsBuilderPlugin',
                    ],
                ],
                [
                    'name' => 'GrapesJsBuilderPlugin',
                    'type' => 'mautic-plugin',
                    'extra' => [
                        'install-directory-name' => 'GrapesJsBuilderPlugin',
                    ],
                ],
            ],
            [
                [
                    'name' => 'mautic/theme-blank-grapejs',
                    'type' => 'mautic-theme',
                ],
                [
                    'name' => 'ThemeBlankGrapejs',
                    'type' => 'mautic-theme',
                ],
            ],
            [
                [
                    'name' => 'mautic/theme-blank-grapejs',
                    'type' => 'mautic-theme',
                    'extra' => [
                        'install-directory-name' => 'blank-grapejs',
                    ],
                ],
                [
                    'name' => 'blank-grapejs',
                    'type' => 'mautic-theme',
                    'extra' => [
                        'install-directory-name' => 'blank-grapejs',
                    ],
                ],
            ],
        ];
    }
}
