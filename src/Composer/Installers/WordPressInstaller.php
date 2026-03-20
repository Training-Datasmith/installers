<?php

declare (strict_types=1);
namespace Composer\Installers;

class Word_Press_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['plugin' => 'wp-content/plugins/{$name}/', 'theme' => 'wp-content/themes/{$name}/', 'muplugin' => 'wp-content/mu-plugins/{$name}/', 'dropin' => 'wp-content/{$name}/'];
}