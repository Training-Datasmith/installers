<?php

declare (strict_types=1);
namespace Composer\Installers;

use Composer\Util\Filesystem;
/**
 * Installer for Bitrix Framework. Supported types of extensions:
 * - `bitrix-d7-module` — copy the module to directory `bitrix/modules/<vendor>.<name>`.
 * - `bitrix-d7-component` — copy the component to directory `bitrix/components/<vendor>/<name>`.
 * - `bitrix-d7-template` — copy the template to directory `bitrix/templates/<vendor>_<name>`.
 *
 * You can set custom path to directory with Bitrix kernel in `composer.json`:
 *
 * ```json
 * {
 *      "extra": {
 *          "bitrix-dir": "s1/bitrix"
 *      }
 * }
 * ```
 *
 * @author Nik Samokhvalov <nik@samokhvalov.info>
 * @author Denis Kulichkin <onexhovia@gmail.com>
 */
class Bitrix_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = [
        'module' => '{$bitrix_dir}/modules/{$name}/',
        // deprecated, remove on the major release (Backward compatibility will be broken)
        'component' => '{$bitrix_dir}/components/{$name}/',
        // deprecated, remove on the major release (Backward compatibility will be broken)
        'theme' => '{$bitrix_dir}/templates/{$name}/',
        // deprecated, remove on the major release (Backward compatibility will be broken)
        'd7-module' => '{$bitrix_dir}/modules/{$vendor}.{$name}/',
        'd7-component' => '{$bitrix_dir}/components/{$vendor}/{$name}/',
        'd7-template' => '{$bitrix_dir}/templates/{$vendor}_{$name}/',
    ];
    /**
     * @var string[] Storage for informations about duplicates at all the time of installation packages.
     */
    private static $checked_duplicates = [];
    public function inflect_package_vars(array $vars): array
    {
        /** @phpstan-ignore-next-line */
        if ($this->composer->get_package()) {
            $extra = $this->composer->get_package()->get_extra();
            if (isset($extra['bitrix-dir'])) {
                $vars['bitrix_dir'] = $extra['bitrix-dir'];
            }
        }
        if (!isset($vars['bitrix_dir'])) {
            $vars['bitrix_dir'] = 'bitrix';
        }
        return parent::inflect_package_vars($vars);
    }
    /**
     * {@inheritdoc}
     */
    protected function template_path(string $path, array $vars = []): string
    {
        $template_path = parent::template_path($path, $vars);
        $this->check_duplicates($template_path, $vars);
        return $template_path;
    }
    /**
     * Duplicates search packages.
     *
     * @param array<string, string> $vars
     */
    protected function check_duplicates(string $path, array $vars = []): void
    {
        $package_type = substr($vars['type'], strlen('bitrix') + 1);
        $local_dir = explode('/', $vars['bitrix_dir']);
        array_pop($local_dir);
        $local_dir[] = 'local';
        $local_dir = implode('/', $local_dir);
        $old_path = str_replace(['{$bitrix_dir}', '{$name}'], [$local_dir, $vars['name']], $this->locations[$package_type]);
        if (in_array($old_path, static::$checked_duplicates)) {
            return;
        }
        if ($old_path !== $path && file_exists($old_path) && $this->io->is_interactive()) {
            $this->io->write_error('    <error>Duplication of packages:</error>');
            $this->io->write_error('    <info>Package ' . $old_path . ' will be called instead package ' . $path . '</info>');
            while (true) {
                switch ($this->io->ask('    <info>Delete ' . $old_path . ' [y,n,?]?</info> ', '?')) {
                    case 'y':
                        $fs = new Filesystem();
                        $fs->remove_directory($old_path);
                        break 2;
                    case 'n':
                        break 2;
                    case '?':
                    default:
                        $this->io->write_error(['    y - delete package ' . $old_path . ' and to continue with the installation', '    n - don\'t delete and to continue with the installation']);
                        $this->io->write_error('    ? - print help');
                        break;
                }
            }
        }
        static::$checked_duplicates[] = $old_path;
    }
}