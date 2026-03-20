<?php

declare (strict_types=1);
namespace Composer\Installers;

use Composer\Composer;
use Composer\IO\Io_Interface;
use Composer\Plugin\Plugin_Interface;
class Plugin implements Plugin_Interface
{
    /** @var Installer */
    private $installer;
    public function activate(Composer $composer, Io_Interface $io): void
    {
        $this->installer = new Installer($io, $composer);
        $composer->get_installation_manager()->add_installer($this->installer);
    }
    public function deactivate(Composer $composer, Io_Interface $io): void
    {
        $composer->get_installation_manager()->remove_installer($this->installer);
    }
    public function uninstall(Composer $composer, Io_Interface $io): void
    {
    }
}