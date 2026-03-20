<?php

declare (strict_types=1);
namespace Composer\Installers;

class Clan_Cats_Framework_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['ship' => 'CCF/orbit/{$name}/', 'theme' => 'CCF/app/themes/{$name}/'];
}