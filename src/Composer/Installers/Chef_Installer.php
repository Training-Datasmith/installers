<?php

declare (strict_types=1);
namespace Composer\Installers;

class Chef_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['cookbook' => 'Chef/{$vendor}/{$name}/', 'role' => 'Chef/roles/{$name}/'];
}