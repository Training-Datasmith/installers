<?php

declare(strict_types=1);

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Composer\Installers\Test;

use Composer\Composer;
use Composer\Config;
use Composer\Downloader\DownloadManager;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Package\AliasPackage;
use Composer\Package\Package;
use Composer\Package\RootPackage;
use Composer\Package\Version\VersionParser;
use Composer\Repository\RepositoryManager;
use Composer\Semver\Constraint\Constraint;
use Composer\Util\Filesystem;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var ?VersionParser */
    private static $parser = null;

    protected static function getVersionParser(): VersionParser
    {
        if (!self::$parser) {
            self::$parser = new VersionParser();
        }

        return self::$parser;
    }

    /**
     * @phpstan-param '='|'=='|'<'|'<='|'>'|'>='|'<>'|'!=' $operator
     */
    protected function getVersionConstraint(string $operator, string $version): Constraint
    {
        return new Constraint(
            $operator,
            self::getVersionParser()->normalize($version)
        );
    }

    protected function getPackage(string $name, string $version): Package
    {
        $normVersion = self::getVersionParser()->normalize($version);

        return new Package($name, $normVersion, $version);
    }

    protected function getAliasPackage(Package $package, string $version): AliasPackage
    {
        $normVersion = self::getVersionParser()->normalize($version);

        return new AliasPackage($package, $normVersion, $version);
    }

    protected function ensureDirectoryExistsAndClear(string $directory): void
    {
        $fs = new Filesystem();
        if (is_dir($directory)) {
            $fs->removeDirectory($directory);
        }
        mkdir($directory, 0777, true);
    }

    protected function getComposer(): Composer
    {
        $composer = new Composer();
        $composer->setPackage($pkg = new RootPackage('root/pkg', '1.0.0.0', '1.0.0'));

        $composer->setConfig(new Config(false));

        $dm = $this->getMockBuilder(DownloadManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $composer->setDownloadManager($dm);

        $im = $this->getMockBuilder(InstallationManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $composer->setInstallationManager($im);

        $rm = $this->getMockBuilder(RepositoryManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $composer->setRepositoryManager($rm);

        return $composer;
    }

    protected function getMockIO(): IOInterface
    {
        return $this->getMockBuilder(IOInterface::class)->getMock();
    }
}
