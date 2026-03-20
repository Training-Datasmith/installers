<?php

declare (strict_types=1);
namespace Composer\Installers;

class Magento_Installer extends Base_Installer
{
    /** @var array<string, string> */
    protected $locations = ['theme' => 'app/design/frontend/{$name}/', 'skin' => 'skin/frontend/default/{$name}/', 'library' => 'lib/{$name}/'];
}