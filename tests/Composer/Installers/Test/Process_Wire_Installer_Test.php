<?php

declare(strict_types=1);

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Installers\ProcessWireInstaller;
use Composer\Package\Package;

class ProcessWireInstallerTest extends TestCase
{
    /** @var Composer */
    private $composer;
    /** @var Package */
    private $package;

    public function setUp(): void
    {
        $this->package = new Package('CamelCased', '1.0', '1.0');
        $this->composer = new Composer();
    }

    public function testInflectPackageVars(): void
    {
        $installer = new ProcessWireInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'CamelCased']);
        $this->assertEquals($result, ['name' => 'CamelCased']);

        $installer = new ProcessWireInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'with-dash']);
        $this->assertEquals($result, ['name' => 'WithDash']);

        $installer = new ProcessWireInstaller($this->package, $this->composer, $this->getMockIO());
        $result = $installer->inflectPackageVars(['name' => 'with_underscore']);
        $this->assertEquals($result, ['name' => 'WithUnderscore']);
    }
}
