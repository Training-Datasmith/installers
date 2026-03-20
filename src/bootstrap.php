<?php

declare (strict_types=1);
use Composer\Autoload\Class_Loader;
function include_if_exists(string $file): ?Class_Loader
{
    if (file_exists($file)) {
        return include $file;
    }
    return null;
}
if (!($loader = include_if_exists(__DIR__ . '/../vendor/autoload.php')) && !$loader = include_if_exists(__DIR__ . '/../../../autoload.php')) {
    die('You must set up the project dependencies, run the following commands:' . PHP_EOL . 'curl -s http://getcomposer.org/installer | php' . PHP_EOL . 'php composer.phar install' . PHP_EOL);
}
return $loader;