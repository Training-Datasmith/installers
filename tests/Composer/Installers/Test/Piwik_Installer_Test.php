<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\PiwikInstaller;
use Composer\Package\Package;

/**
 * Class PiwikInstallerTest
 *
 * @package Composer\Installers\Test
 */
class PiwikInstallerTest extends TestCase
{
    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var Package
     */
    private $package;

    public function setUp(): void
    {
        $this->package = new Package('VisitSummary', '1.0', '1.0');
        $this->composer = new Composer();
    }

    public function testInflectPackageVars(): void
    {
        $installer = new PiwikInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'VisitSummary']);
        $this->assertEquals($result, ['name' => 'VisitSummary']);

        $installer = new PiwikInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'visit-summary']);
        $this->assertEquals($result, ['name' => 'VisitSummary']);

        $installer = new PiwikInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'visit_summary']);
        $this->assertEquals($result, ['name' => 'VisitSummary']);
    }
}
