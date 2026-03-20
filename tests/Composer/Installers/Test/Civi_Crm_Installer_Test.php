<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Installers\CiviCrmInstaller;
use Composer\Package\Package;

class CiviCrmInstallerTest extends TestCase
{
    /**
     * @var CiviCrmInstaller
     */
    private $installer;

    public function setUp(): void
    {
        $this->installer = new CiviCrmInstaller(
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
            [
                'civicrm-ext',
                'org.civicrm.shoreditch',
                'org.civicrm.shoreditch',
            ],
            [
                'civicrm-ext',
                'org.civicrm.flexmailer',
                'org.civicrm.flexmailer',
            ],
            [
                'civicrm-ext',
                'uk.co.vedaconsulting.mosaico',
                'uk.co.vedaconsulting.mosaico',
            ],
        ];
    }
}
